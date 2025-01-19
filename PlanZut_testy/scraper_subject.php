<?php
ini_set('memory_limit', '512M');
use Patryk\PlanZut\Subject;

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

// Funkcja do pobrania przedmiotów z API dla danego zapytania
function fetchSubjectsFromAPI(string $query): array
{
    $url = "https://plan.zut.edu.pl/schedule.php?kind=subject&query=" . urlencode($query);
    $response = file_get_contents($url);

    if ($response === false) {
        echo "Błąd podczas pobierania danych z API dla zapytania: $query\n";
        return [];
    }

    $subjects = json_decode($response, true);
    if (!is_array($subjects)) {
        echo "Nieprawidłowy format odpowiedzi API dla zapytania: $query\n";
        return [];
    }

    return $subjects;
}

// Funkcja do przetwarzania nazwy przedmiotu
function parseSubjectItem(string $item): array
{
    $pattern = '/^(.*?)\s+\((.*?),\s+(.*?),\s+(.*?)\)/';
    if (preg_match($pattern, $item, $matches)) {
        return [
            'name' => trim($matches[1] ?? 'Nieznany przedmiot'),
            'department' => trim($matches[2] ?? 'Nieznany wydział'),
            'direction' => trim($matches[3] ?? 'Nieznany kierunek'),
            'study_type' => trim($matches[4] ?? 'Nieznany typ studiów'),
        ];
    }

    return [
        'name' => 'Nieznany przedmiot',
        'department' => 'Nieznany wydział',
        'direction' => 'Nieznany kierunek',
        'study_type' => 'Nieznany typ studiów',
    ];
}

// Sprawdzanie, czy rekord już istnieje w bazie danych
function subjectExists(string $name, string $department, string $direction, string $studyType): bool
{
    global $entityManager;

    $repository = $entityManager->getRepository(Subject::class);

    return (bool)$repository->findOneBy([
        'subject_name' => $name,
        'subject_department' => $department,
        'subject_direction' => $direction,
        'subject_study_type' => $studyType,
    ]);
}

// Główna logika
function scrapeSubjects()
{
    global $entityManager;

    $alphabet = array_merge(range('0', '9'), range('a', 'z')); // Zapytania od 0 do 9 oraz od a do z

    foreach ($alphabet as $query) {
        echo "Pobieranie danych dla zapytania: $query\n";

        $subjects = fetchSubjectsFromAPI($query);

        foreach ($subjects as $subject) {
            if (!isset($subject['item']) || empty($subject['item'])) {
                echo "Pominięto rekord: brak danych o przedmiocie.\n";
                continue;
            }

            $parsedSubject = parseSubjectItem($subject['item']);

            // Sprawdzanie duplikatów przed zapisem
            if (subjectExists(
                $parsedSubject['name'],
                $parsedSubject['department'],
                $parsedSubject['direction'],
                $parsedSubject['study_type']
            )) {
                echo "Rekord już istnieje: " . $parsedSubject['name'] . "\n";
                continue;
            }

            // Tworzenie encji przedmiotu
            $subjectEntity = new Subject();
            $subjectEntity->setSubjectName($parsedSubject['name']);
            $subjectEntity->setSubjectDepartment($parsedSubject['department']);
            $subjectEntity->setSubjectDirection($parsedSubject['direction']);
            $subjectEntity->setSubjectStudyType($parsedSubject['study_type']);

            // Zapis do bazy danych
            $entityManager->persist($subjectEntity);
        }
        $entityManager->flush();
        $entityManager->clear(); // Usuwa wszystkie obiekty z pamięci
    }

    // Zapisanie wszystkich zmian do bazy
    try {
        $entityManager->flush();
        echo "Zakończono zapis przedmiotów do bazy danych.\n";
    } catch (Exception $e) {
        echo "Wystąpił błąd podczas zapisu do bazy: " . $e->getMessage() . "\n";
    }
}

scrapeSubjects();
