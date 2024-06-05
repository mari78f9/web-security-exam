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
            case_id           VARCHAR(255),
            case_description  TEXT,
            case_suspect      TEXT,
            case_type         VARCHAR(50),
            case_location     VARCHAR(255),
            case_date         INT,
            case_solved       INT,
            case_created_at   INT,
            case_updated_at   INT,
            case_deleted_at   INT,
            PRIMARY KEY (case_id)
        )
    ');
    $q->execute();

    $values = '';

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
        $case_date = strtotime($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'));
        $case_solved = rand(0, 1);
        $case_created_at = time();
        $case_updated_at = 0;
        $case_deleted_at = 0;

        $values .= "('$case_id', '$case_description', '$case_suspect', '$case_type', '$case_location', $case_date, $case_solved, $case_created_at, $case_updated_at, $case_deleted_at),";
    }

    $values = rtrim($values, ',');
    $q = $db->prepare("INSERT INTO cases VALUES $values");
    $q->execute();

    echo "+ cases" . PHP_EOL;
} catch (Exception $e) {
    echo $e;
}
?>