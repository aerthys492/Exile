<?php

use Patryk\PlanZut\Group;

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

// Tablica do przechowywania nazw grup
$groupNames = [];

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

    // Wyodrębnianie nazw grup
    foreach ($data as $lesson) {
        if (isset($lesson['group_name'])) {
            $groupName = $lesson['group_name'];

            // Dodawanie unikalnych nazw grup do tablicy
            if (!in_array($groupName, $groupNames)) {
                $groupNames[] = $groupName;
            }
        }
    }

    // Co 1000 numerów zapisuj dane do bazy i opróżniaj tablicę
    if ($number % 1000 === 0 || $number === $endNumber) {
        foreach ($groupNames as $name) {
            // Sprawdzenie, czy nazwa grupy już istnieje w bazie
            $existingGroup = $entityManager->getRepository(Group::class)
                ->findOneBy(['group_name' => $name]);

            if (!$existingGroup) {
                // Tworzenie nowego obiektu grupy
                $group = new Group();
                $group->setGroupName($name);

                // Zapisanie do bazy
                $entityManager->persist($group);
            }
        }

        // Flushing zapisanych danych
        $entityManager->flush();
        $entityManager->clear();

        // Opróżnianie tablicy
        $groupNames = [];
    }
}

echo "Scraper zakończył działanie.\n";
