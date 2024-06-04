<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try {
    $db = _db();
    $q = $db->prepare('DROP TABLE IF EXISTS crimes');
    $q->execute();


    $q = $db->prepare('
        CREATE TABLE crimes (
            crime_id           VARCHAR(255),
            crime_name         VARCHAR(255),
            crime_description  TEXT,
            crime_suspect      TEXT,
            crime_category     VARCHAR(50),
            crime_location     VARCHAR(255),
            crime_date         INT,
            crime_solved       INT,
            crime_created_at   INT,
            crime_updated_at   INT,
            crime_deleted_at   INT,
            PRIMARY KEY (crime_id)
        )
    ');
    $q->execute();

    $values = '';

    for ($i = 0; $i < 20; $i++) {
        $crime_id = bin2hex(random_bytes(5));
        $crime_name = str_replace("'", "''", $faker->sentence(3));
        $crime_description = str_replace("'", "''", $faker->paragraph(3));
        $crime_suspect = str_replace("'", "''", $faker->firstName, $faker->firstName);
        $crime_category = $faker->randomElement(['Theft', 'Assault', 'Burglary', 'Vandalism', 'Fraud']);
        $crime_location = str_replace("'", "''", $faker->address);
        $crime_date = strtotime($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'));
        $crime_solved = rand(0, 1);
        $crime_created_at = time();
        $crime_updated_at = 0;
        $crime_deleted_at = 0;

        $values .= "('$crime_id', '$crime_name', '$crime_description', '$crime_suspect', '$crime_category', '$crime_location', $crime_date, $crime_solved, $crime_created_at, $crime_updated_at, $crime_deleted_at),";
    }

    $values = rtrim($values, ',');
    $q = $db->prepare("INSERT INTO crimes VALUES $values");
    $q->execute();

    echo "+ crimes" . PHP_EOL;
} catch (Exception $e) {
    echo $e;
}
?>