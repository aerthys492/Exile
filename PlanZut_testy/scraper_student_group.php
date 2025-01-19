<?php

use Patryk\PlanZut\Group;
use Patryk\PlanZut\StudentGroup;

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

// Funkcja do odtwarzania EntityManager w razie potrzeby
function getEntityManager()
{
    return require __DIR__ . '/bootstrap.php';
}

// Inicjalizacja EntityManager
$entityManager = getEntityManager();

// Ustawienia API
$apiUrlTemplate = "https://plan.zut.edu.pl/schedule_student.php?number={number}&start=2025-01-13&end=2025-01-27";

// Ustawienia zakresu
$startNumber = 53101;
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

            // Znajdowanie id_group na podstawie group_name
            $group = $entityManager->getRepository(Group::class)
                ->findOneBy(['group_name' => $groupName]);

            if ($group) {
                $idGroup = $group->getIdGroup();

                // Tworzenie nowego obiektu StudentGroup
                $studentGroup = new StudentGroup();
                $studentGroup->setIdStudent($idStudent);
                $studentGroup->setIdGroup($idGroup);

                // Zapisanie pojedynczego rekordu
                try {
                    $entityManager->persist($studentGroup);
                    $entityManager->flush();
                } catch (Exception $e) {
                    echo "Pominięto rekord id_student: $idStudent, id_group: $idGroup z powodu błędu: " . $e->getMessage() . "\n";

                    // Odtworzenie EntityManager w przypadku zamknięcia
                    if (strpos($e->getMessage(), 'EntityManager is closed') !== false) {
                        $entityManager = getEntityManager();
                    }
                }
            }
        }
    }
}

echo "Scraper zakończył działanie.\n";
