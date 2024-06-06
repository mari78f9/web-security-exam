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
            role_id           VARCHAR(4),
            role_name         VARCHAR(20),
            PRIMARY KEY (role_id)
        )
    ');
    $q->execute();

    $role_id = bin2hex(random_bytes(2));
    $created_at = time();

    // Insert unique roles
    $role_ids = [bin2hex(random_bytes(2)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2))];
    $q = $db->prepare("INSERT INTO roles (role_id, role_name) VALUES 
                      ('$role_ids[0]', 'citizen'),
                      ('$role_ids[1]', 'detective'),
                      ('$role_ids[2]', 'lawyer')");
    $q->execute();

    echo "+ roles" . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(); // Output the error message for debugging
}




