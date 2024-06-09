<?php
// Include the required file for database and other configurations
require_once __DIR__.'/../_.php';
// Include the Faker library for generating fake data
require_once __DIR__ . '/Faker/autoload.php';
// Create a Faker instance to generate fake data
$faker = Faker\Factory::create();

try {

    // Connecting to database with _db() function from database.php
    $db = _db();
    // Prepare a SQL statement to drop the cases table if it exists
    $q = $db->prepare('DROP TABLE IF EXISTS cases');
    $q->execute();

    // Prepare a SQL statement to create the users table with the specified schema
    $q = $db->prepare('
        CREATE TABLE cases (
            case_id           VARCHAR(10),
            case_description  TEXT,
            case_tip          TEXT,
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
     $sql = "INSERT INTO cases (case_id, case_description, case_tip, case_suspect, case_type, case_location, case_solved, case_created_at, case_updated_at, case_is_public) VALUES (:case_id, :case_description, :case_tip, :case_suspect, :case_type, :case_location, :case_solved, :case_created_at, :case_updated_at, :case_is_public)";

     // Prepare the statement
     $q = $db->prepare($sql);

    // Loop for generating 20 fake cases
    for ($i = 0; $i < 20; $i++) {
        $case_id = bin2hex(random_bytes(5)); // Random case ID wit 10 characters
        
        // Picking a random description from the given options
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
        
        $case_tip = ''; // Empty string for case tips
        $case_suspect = str_replace("'", "''", $faker->firstName . ' ' . $faker->lastName);        
        
        // Picking a random case type from the given options
        $case_type = $faker->randomElement(['Theft', 
        'Assault', 
        'Burglary', 
        'Vandalism', 
        'Fraud']);
        
        $case_location = str_replace("'", "''", $faker->address);
        $case_solved = rand(0, 1); // Randomly deciding if the case is solved or not
        $case_created_at = time();
        $case_updated_at = 0;
        $case_is_public = rand(0,1); // Randomly deciding if the case is public or private

        // Bind parameters and execute the prepared statement
        $q->bindParam(':case_id', $case_id);
        $q->bindParam(':case_description', $case_description);
        $q->bindParam(':case_tip', $case_tip);
        $q->bindParam(':case_suspect', $case_suspect);
        $q->bindParam(':case_type', $case_type);
        $q->bindParam(':case_location', $case_location);
        $q->bindParam(':case_solved', $case_solved);
        $q->bindParam(':case_created_at', $case_created_at);
        $q->bindParam(':case_updated_at', $case_updated_at);
        $q->bindParam(':case_is_public', $case_is_public);

        $q->execute();
    }

    echo "+ cases" . PHP_EOL; // Success message if the seeding is completed
} catch (Exception $e) {
    echo $e->getMessage(); // Error message if not
}
?>