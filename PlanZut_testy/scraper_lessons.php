<?php
use Patryk\PlanZut\Lesson;
use Patryk\PlanZut\Subject;
use Patryk\PlanZut\Instructor;
use Patryk\PlanZut\Group;
use Patryk\PlanZut\Room;
use Doctrine\ORM\EntityManager;

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

// Inicjalizacja EntityManager
$entityManager = require __DIR__ . '/bootstrap.php';

// Ustawienia API
$apiUrlTemplate = "https://plan.zut.edu.pl/schedule_student.php?number={number}&start=2025-01-13&end=2025-01-27";

// Ustawienia zakresu
$startNumber = 53000;
$endNumber = 54000;

// Główna pętla scrapera
for ($number = $startNumber; $number <= $endNumber; $number++) {
    $url = str_replace('{number}', $number, $apiUrlTemplate);

    // Pobranie danych z API
    $response = file_get_contents($url);

    // Jeśli odpowiedź jest pusta, przejdź do następnego numeru
    if ($response === false || empty($response)) {
        continue;
    }

    // Dekodowanie JSON
    $data = json_decode($response, true);

    // Jeśli dane są nieprawidłowe, przejdź do następnego numeru
    if (!is_array($data)) {
        continue;
    }

    // Pobranie id_student
    $idStudent = $number;

    // Przetwarzanie danych z API
    foreach ($data as $lesson) {
        if (isset($lesson['group_name'])) {
            $groupName = $lesson['group_name'];

            // Znalezienie obiektu Group na podstawie group_name
            $group = $entityManager->getRepository(Group::class)
                ->findOneBy(['group_name' => $groupName]);

            if ($group) {
               
                $subjectName = $lesson['subject'];

                $subject = $entityManager->getRepository(Subject::class)
                    ->createQueryBuilder('s')
                    ->where('LOWER(s.subject_name) = LOWER(:subject_name)')
                    ->setParameter('subject_name', $subjectName)
                    ->setMaxResults(1) // Maksymalna liczba wyników to 1
                    ->getQuery()
                    ->getOneOrNullResult();

                
                $idSubject = $subject ? $subject : null;

                // Znalezienie obiektu Instructor na podstawie worker (imienia i nazwiska)
                $instructorName = $lesson['worker']; 
                list($firstName, $lastName) = explode(' ', $instructorName, 2);

                $instructor = $entityManager->getRepository(Instructor::class)
                    ->findOneBy(['name' => $firstName, 'surname' => $lastName]); 

                $idInstructor = $instructor ? $instructor : null; 


                // Rozdzielanie nazwy sali
                $room = $lesson['room'];  // "WI WI1- 303"

                // Rozdzielenie na część wydziału i sali
                preg_match('/^([A-Za-z\s]+)(\d[\d\s\-]+)$/', $room, $matches);

                
                if (count($matches) === 3) {
                    $department = trim($matches[1]);  // "WI WI"
                    $class_name = trim($matches[2]);  // "1- 303"

                    // Wyszukiwanie sali w bazie danych
                    $roomEntity = $entityManager->getRepository(Room::class)
                        ->findOneBy(['department' => $department, 'class_name' => $class_name]);
                  
                }

                // Rozdzielanie daty i czasu
                $date = substr($lesson['start'], 0, 10);  // YYYY-MM-DD
                $timeStart = substr($lesson['start'], 11);  // HH:MM:SS
                $timeEnd = substr($lesson['end'], 11);    // HH:MM:SS

                // Tworzenie nowego obiektu Lesson
                $lessonEntity = new Lesson();
                $lessonEntity->setIdSubject($idSubject);  
                $lessonEntity->setIdLecturer($idInstructor); 
                $lessonEntity->setIdClass($roomEntity);  
                $lessonEntity->setIdGroup($group);  
                $lessonEntity->setDateLessons(new DateTime($date));  
                $lessonEntity->setTimeStart(new DateTime($timeStart));  
                $lessonEntity->setTimeEnd(new DateTime($timeEnd));  
                $lessonEntity->setDescription($lesson['description']);

                try {
                    // Zapisanie do bazy danych
                    $entityManager->persist($lessonEntity);
                    // Natychmiastowy zapis do bazy
                    $entityManager->flush();
                } catch (Exception $e) {
                    echo "Błąd podczas zapisu zajęć: " . $e->getMessage() . "\n";
                }
            }
        }
    }
}

echo "Scraper zakończył działanie.\n";
