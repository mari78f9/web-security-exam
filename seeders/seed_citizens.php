<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS citizens');
  $q->execute();


  $q = $db->prepare('
  CREATE TABLE citizens(
      citizen_id           VARCHAR(255),
      citizen_name         VARCHAR(20),
      citizen_last_name    VARCHAR(20),
      citizen_email        VARCHAR(255) UNIQUE,
      citizen_password     TEXT,
      citizen_address      VARCHAR(255),
      citizen_created_at   INT,
      citizen_updated_at   INT,
      citizen_deleted_at   INT,
      citizen_is_blocked   INT,
      PRIMARY KEY (citizen_id)
  )
');
$q->execute();

  $values = '';

  // Password
  $citizen_password = password_hash('password', PASSWORD_DEFAULT);
  for($i = 0; $i < 20; $i++){
    $citizen_id = bin2hex(random_bytes(5));
    $citizen_name = str_replace("'", "''", $faker->firstName);
    $citizen_last_name = str_replace("'", "''", $faker->lastName);
    $citizen_email = $faker->unique->email;
    $citizen_address = str_replace("'", "''", $faker->address);
    $citizen_created_at = time();
    $citizen_updated_at = 0;
    $citizen_deleted_at = 0;
    $citizen_is_blocked = rand(0,1);
    $values .= "('$citizen_id', '$citizen_name', '$citizen_last_name', '$citizen_email', '$citizen_password', 
    '$citizen_address', $citizen_created_at, $citizen_updated_at, $citizen_deleted_at, $citizen_is_blocked),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO citizens VALUES $values");
  $q->execute();

  echo "+ citizens".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









