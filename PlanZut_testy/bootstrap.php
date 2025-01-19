<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/src/Entity"], $isDevMode, null, null, false);

// Parametry połączenia z bazą danych
$conn = [
    'dbname' => 'baza',
    'user' => 'root',
    'password' => '',
    'host' => '127.0.0.1',
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/baza.db',
];

$entityManager = EntityManager::create($conn, $config);

return $entityManager;
