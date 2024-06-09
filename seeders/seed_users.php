<?php
// Include the required file for database and other configurations
require_once __DIR__.'/../_.php';
// Include the Faker library for generating fake data
require_once __DIR__ . '/Faker/autoload.php';
// Create a Faker instance to generate fake data
$faker = Faker\Factory::create();

try{

  // Connecting to database with _db() function from database.php
  $db = _db();
  // Prepare a SQL statement to drop the users table if it exists
  $q = $db->prepare('DROP TABLE IF EXISTS users');
  $q->execute();

  // Get roles to assign to users from the roles table
  $q = $db->prepare('SELECT role_id FROM roles');
  $q->execute();
  $roles = $q->fetchAll(PDO::FETCH_ASSOC); // Fetch role_id and role_name

  // Prepare a SQL statement to create the users table with the specified schema
  $q = $db->prepare('
  CREATE TABLE users(
      user_id           VARCHAR(10),
      user_name         VARCHAR(20),
      user_last_name    VARCHAR(50),
      user_email        VARCHAR(255) UNIQUE,
      user_password     TEXT,
      role_id_fk        BIGINT(20) UNSIGNED,
      user_created_at   CHAR(10),
      user_updated_at   CHAR(10),
      user_deleted_at   CHAR(10),
      user_is_blocked   TINYINT(1),
      PRIMARY KEY (user_id),
      INDEX (role_id_fk),
      FOREIGN KEY (role_id_fk) REFERENCES roles(role_id) ON DELETE CASCADE ON UPDATE RESTRICT
  )
');

// Execute the statement to create table
$q->execute();

  $values = '';

  // Admin/lieutenant details, create one with role_id = 4 and id = 1
  $admin_password = password_hash('password', PASSWORD_DEFAULT);
  $admin_created_at = time();
  $admin_updated_at = 0;
  $admin_deleted_at = 0;  
  $values .= "('1', 'Admin', 'Admin', 'admin@company.com', 
  '$admin_password', 4, $admin_created_at, $admin_updated_at, $admin_deleted_at, 0),";


  $user_password = password_hash('password', PASSWORD_DEFAULT); // Hashing the passwords
  
  // Loop to generate 10 fake users
  for($i = 0; $i < 10; $i++){
    $user_id = bin2hex(random_bytes(5)); // Random id with 10 characters
    $user_name = str_replace("'", "''", $faker->firstName);
    $user_last_name = str_replace("'", "''", $faker->lastName);
    $user_email = $faker->unique->email;
    $role = $roles[array_rand($roles)];
    $role_id_fk = rand(1, 3); // Random role_id from roles table
    $user_created_at = time();
    $user_updated_at = 0;
    $user_deleted_at = 0;
    $user_is_blocked = rand(0,1); // Randomly deciding if the user is blocked
    
    // Add the user details to the values string
    $values .= "('$user_id', '$user_name', '$user_last_name', '$user_email', '$user_password',
     '$role_id_fk', $user_created_at, $user_updated_at, $user_deleted_at, $user_is_blocked),";
  }
  // Remove the comma from the values string
  $values = rtrim($values, ',');
  // Prepare a SQL statement to insert the users into the table
  $q = $db->prepare("INSERT INTO users VALUES $values");
  $q->execute();

  echo "+ users".PHP_EOL; // Succes message if the seeding is completed
}catch(Exception $e){
  echo $e; // Error message if not
}