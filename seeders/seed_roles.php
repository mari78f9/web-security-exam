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
            role_id           BIGINT(20) UNSIGNED AUTO_INCREMENT,
            role_name         VARCHAR(20),
            PRIMARY KEY (role_id)
        )
    ');
    $q->execute();

    // Insert unique roles
    $q = $db->prepare("INSERT INTO roles (role_name) VALUES 
                      ('citizen'),
                      ('detective'),
                      ('lawyer')");
    $q->execute();

    echo "+ roles" . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(); // Output the error message for debugging
}