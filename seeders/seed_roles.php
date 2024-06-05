<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try {
    $db = _db();
    $q = $db->prepare('DROP TABLE IF EXISTS roles');
    $q->execute();

    $q = $db->prepare('
        CREATE TABLE roles(
            role_id           VARCHAR(255),
            role_name         VARCHAR(20),
            role_created_at   INT,
            role_updated_at   INT,
            PRIMARY KEY (role_id)
        )
    ');
    $q->execute();

    $role_id = bin2hex(random_bytes(2));
    $created_at = time();

    $q = $db->prepare("INSERT INTO roles VALUES 
                      ('$role_id', 'citizen', $created_at, 0),
                      ('$role_id', 'detective', $created_at, 0),
                      ('$role_id', 'lawyer', $created_at, 0)");
    $q->execute();

    echo "+ roles" . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(); // Output the error message for debugging
}




