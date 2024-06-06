<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try {
    $db = _db();
    $q = $db->prepare('DROP TABLE IF EXISTS cases');
    $q->execute();

    $q = $db->prepare('
        CREATE TABLE cases (
            case_id           VARCHAR(10),
            case_description  TEXT,
            case_suspect      TEXT,
            case_type         VARCHAR(50),
            case_location     VARCHAR(255),
            case_solved       TINYINT(1),
            case_created_at   CHAR(10),
            case_updated_at   CHAR(10),
            case_is_public    TINYINT(1),
            PRIMARY KEY (case_id)
        )
    ');
    $q->execute();

     // Prepare an SQL template for inserting cases
     $sql = "INSERT INTO cases (case_id, case_description, case_suspect, case_type, case_location, case_solved, case_created_at, case_updated_at, case_is_public) VALUES (:case_id, :case_description, :case_suspect, :case_type, :case_location, :case_solved, :case_created_at, :case_updated_at, :case_is_public)";

     // Prepare the statement
     $q = $db->prepare($sql);

    for ($i = 0; $i < 20; $i++) {
        $case_id = bin2hex(random_bytes(5));
        $case_description = $faker->randomElement(['Theft of a Car',
        'Assault with a Deadly Weapon',
        'Burglary of a Residence',
        'Vandalism of Public Property',
        'Fraudulent Activities',
        'Murder of a Person',
        'Rape of a Minor',
        'Robbery of a Bank',
        'Arson of a Building',
        'Kidnapping of a Child']);
        $case_suspect = str_replace("'", "''", $faker->firstName . ' ' . $faker->lastName);        $case_type = $faker->randomElement(['Theft', 'Assault', 'Burglary', 'Vandalism', 'Fraud']);
        $case_location = str_replace("'", "''", $faker->address);
        $case_solved = rand(0, 1);
        $case_created_at = time();
        $case_updated_at = 0;
        $case_is_public = rand(0,1);

        // Bind parameters and execute the prepared statement
        $q->bindParam(':case_id', $case_id);
        $q->bindParam(':case_description', $case_description);
        $q->bindParam(':case_suspect', $case_suspect);
        $q->bindParam(':case_type', $case_type);
        $q->bindParam(':case_location', $case_location);
        $q->bindParam(':case_solved', $case_solved);
        $q->bindParam(':case_created_at', $case_created_at);
        $q->bindParam(':case_updated_at', $case_updated_at);
        $q->bindParam(':case_is_public', $case_is_public);

        $q->execute();
    }

    echo "+ cases" . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(); 
}
?>