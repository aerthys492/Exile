<?php

use Patryk\PlanZut\Room;

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

// Funkcja do pobrania sal z API dla danego zapytania
function fetchRoomsFromAPI(string $query): array
{
    $url = "https://plan.zut.edu.pl/schedule.php?kind=room&query=" . urlencode($query);
    $response = file_get_contents($url);

    if ($response === false) {
        echo "Błąd podczas pobierania danych z API dla zapytania: $query\n";
        return [];
    }

    $rooms = json_decode($response, true);
    if (!is_array($rooms)) {
        echo "Nieprawidłowy format odpowiedzi API dla zapytania: $query\n";
        return [];
    }

    return $rooms;
}

// Funkcja do podziału nazwy sali na wydział i nazwę sali
function splitRoomName(string $item): array
{
    $parts = preg_split('/(?<=\D)(?=\d)/', $item, 2); // Rozdziela przed pierwszą cyfrą
    $department = trim($parts[0] ?? 'Nieznany wydział'); // Część tekstowa
    $roomName = trim($parts[1] ?? 'Nieznana sala'); // Część z cyframi

    return [$department, $roomName];
}

// Sprawdzanie, czy rekord już istnieje w bazie danych
function roomExists(string $department, string $roomName): bool
{
    global $entityManager;

    $repository = $entityManager->getRepository(Room::class);

    return (bool)$repository->findOneBy([
        'department' => $department,
        'class_name' => $roomName,
    ]);
}

// Główna logika
function scrapeRooms()
{
    global $entityManager;

    $alphabet = array_merge(range('0', '9'), range('a', 'z')); // Zapytania od 0 do 9 oraz od a do z

    foreach ($alphabet as $query) {
        echo "Pobieranie danych dla zapytania: $query\n";

        $rooms = fetchRoomsFromAPI($query);

        foreach ($rooms as $room) {
            if (!isset($room['item']) || empty($room['item'])) {
                echo "Pominięto rekord: brak danych o sali.\n";
                continue;
            }

            [$department, $roomName] = splitRoomName($room['item']);

            // Sprawdzanie duplikatów przed zapisem
            if (roomExists($department, $roomName)) {
                echo "Rekord już istnieje: $department - $roomName\n";
                continue;
            }

            // Tworzenie encji sali
            $roomEntity = new Room();
            $roomEntity->setDepartment($department);
            $roomEntity->setClassName($roomName);

            // Zapis do bazy danych
            $entityManager->persist($roomEntity);
        }
    }

    // Zapisanie wszystkich zmian do bazy
    try {
        $entityManager->flush();
        echo "Zakończono zapis sal do bazy danych.\n";
    } catch (Exception $e) {
        echo "Wystąpił błąd podczas zapisu do bazy: " . $e->getMessage() . "\n";
    }
}

scrapeRooms();


// Ręczne usuwanie duplikatów w bazie (na wszelki wypadek)
// DELETE FROM class
// WHERE id_class NOT IN (
//     SELECT MIN(id_class)
//     FROM class
//     GROUP BY department, class_name
// );

