<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS lawyers');
  $q->execute();

  $q = $db->prepare('
  CREATE TABLE lawyers(
      lawyer_id           VARCHAR(255),
      lawyer_name         VARCHAR(20),
      lawyer_last_name    VARCHAR(20),
      lawyer_email        VARCHAR(255) UNIQUE,
      lawyer_password     TEXT,
      lawyer_address      VARCHAR(255),
      lawyer_created_at   INT,
      lawyer_updated_at   INT,
      lawyer_deleted_at   INT,
      lawyer_is_blocked   INT,
      PRIMARY KEY (lawyer_id)
  )
');
$q->execute();

  $values = '';

  // Password
  $lawyer_password = password_hash('password', PASSWORD_DEFAULT);
  for($i = 0; $i < 20; $i++){
    $lawyer_id = bin2hex(random_bytes(5));
    $lawyer_name = str_replace("'", "''", $faker->firstName);
    $lawyer_last_name = str_replace("'", "''", $faker->lastName);
    $lawyer_email = $faker->unique->email;
    $lawyer_address = str_replace("'", "''", $faker->address);
    $lawyer_created_at = time();
    $lawyer_updated_at = 0;
    $lawyer_deleted_at = 0;
    $lawyer_is_blocked = rand(0,1);
    $values .= "('$lawyer_id', '$lawyer_name', '$lawyer_last_name', '$lawyer_email', '$lawyer_password', 
    '$lawyer_address', $lawyer_created_at, $lawyer_updated_at, $lawyer_deleted_at, $lawyer_is_blocked),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO lawyers VALUES $values");
  $q->execute();

  echo "+ lawyers".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









