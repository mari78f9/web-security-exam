<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS detectives');
  $q->execute();

  $q = $db->prepare('
  CREATE TABLE detectives(
      detective_id           VARCHAR(255),
      detective_name         VARCHAR(20),
      detective_last_name    VARCHAR(20),
      detective_email        VARCHAR(255) UNIQUE,
      detective_password     TEXT,
      detective_address      VARCHAR(255),
      detective_role_name    VARCHAR(20),
      detective_created_at   INT,
      detective_updated_at   INT,
      detective_deleted_at   INT,
      detective_is_blocked   INT,
      PRIMARY KEY (detective_id)
  )
');
$q->execute();

  $values = '';

  // Password
  $detective_password = password_hash('password', PASSWORD_DEFAULT);
  for($i = 0; $i < 20; $i++){
    $detective_id = bin2hex(random_bytes(5));
    $detective_name = str_replace("'", "''", $faker->firstName);
    $detective_last_name = str_replace("'", "''", $faker->lastName);
    $detective_email = $faker->unique->email;
    $detective_address = str_replace("'", "''", $faker->address);
    $detective_created_at = time();
    $detective_updated_at = 0;
    $detective_deleted_at = 0;
    $detective_is_blocked = rand(0,1);
    $values .= "('$detective_id', '$detective_name', '$detective_last_name', '$detective_email', '$detective_password', 
    '$detective_address', $detective_created_at, $detective_updated_at, $detective_deleted_at, $detective_is_blocked),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO detectives VALUES $values");
  $q->execute();

  echo "+ detectives".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









