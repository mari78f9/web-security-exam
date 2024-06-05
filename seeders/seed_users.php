<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS users');
  $q->execute();

  // Get roles to assign to users
  $q = $db->prepare('SELECT role_name FROM roles');
  $q->execute();
  $roles = $q->fetchAll(PDO::FETCH_COLUMN); // ["citizen","detective","lawyer"]

  $q = $db->prepare('
  CREATE TABLE users(
      user_id           VARCHAR(255),
      user_name         VARCHAR(20),
      user_last_name    VARCHAR(20),
      user_email        VARCHAR(255) UNIQUE,
      user_password     TEXT,
      user_address      VARCHAR(255),
      user_role_name    VARCHAR(20),
      user_created_at   INT,
      user_updated_at   INT,
      user_deleted_at   INT,
      user_is_blocked   INT,
      PRIMARY KEY (user_id)
  )
');
$q->execute();

  $values = '';

  // Password
  $user_password = password_hash('password', PASSWORD_DEFAULT);
  for($i = 0; $i < 100; $i++){
    $user_id = bin2hex(random_bytes(5));
    $user_name = str_replace("'", "''", $faker->firstName);
    $user_last_name = str_replace("'", "''", $faker->lastName);
    $user_email = $faker->unique->email;
    $user_address = str_replace("'", "''", $faker->address);
    $user_role_name = $roles[array_rand($roles)];
    $user_created_at = time();
    $user_updated_at = 0;
    $user_deleted_at = 0;
    $user_is_blocked = rand(0,1);
    $values .= "('$user_id', '$user_name', '$user_last_name', '$user_email', '$user_password', 
    '$user_address', '$user_role_name', $user_created_at, $user_updated_at, $user_deleted_at, $user_is_blocked),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO users VALUES $values");
  $q->execute();

  echo "+ users".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









