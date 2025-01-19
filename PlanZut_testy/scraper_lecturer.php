<?php

require_once 'bootstrap.php';
use Patryk\PlanZut\Instructor;



$alphabet = range('A', 'Z'); // Zakres alfabetu

foreach ($alphabet as $letter) {
    $url = "https://plan.zut.edu.pl/schedule.php?kind=teacher&query={$letter}";
    $response = file_get_contents($url);
    $instructors = json_decode($response, true);

    foreach ($instructors as $instructor) {
        if (!isset($instructor['item']) || empty($instructor['item'])) {
            echo "Pominięto rekord: brak danych o nauczycielu.\n";
            continue;
        }
    
        $item = $instructor['item'];
    
        // Obsługa przypadków z separatorami
        if (strpos($item, '-') !== false) {
            // Format: "Nazwisko - Imię"
            [$surname, $name] = array_map('trim', explode('-', $item));
        } else {
            // Format bez separatora: "Imię Nazwisko"
            $parts = array_filter(array_map('trim', explode(' ', $item))); // Usunięcie dodatkowych spacji
    
            if (count($parts) < 2) {
                echo "Pominięto rekord: niepełne dane w '$item'.\n";
                continue;
            }
    
            $surname = array_pop($parts); // Ostatni element to nazwisko
            $name = implode(' ', $parts); // Reszta to imię
        }
    
        // Tworzenie obiektu encji
        $lecturer = new Instructor();
        $lecturer->setName($name);
        $lecturer->setSurname($surname);
    
        // Zapis do bazy
        $entityManager->persist($lecturer);
    }
    
}

// Zapisz zmiany do bazy
$entityManager->flush();

echo "Dane nauczycieli zostały zapisane do bazy danych.\n";
