<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';
header('Content-Type: application/json');

try{

  // Checks if the exisiting data of different informations, 
  // matches with the required specifications of the value (fx string-lenght or speciel-characters)
  _validate_user_email();        // Email-validation function from the master-file 
  _validate_user_password();     // Password-validation function from the master-file 


  // Checks in the database (based on the user_email) if the provided info is an exisitng user
  $db = _db();
  $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  
  $user = $q->fetch();

  // If the user doesn't exist, show an error message
  if( ! $user ){
    throw new Exception('invalid credentials', 400);
  }

  // Check if the found user has a valid password
  if( ! password_verify($_POST['user_password'], $user['user_password']) ){
    throw new Exception('invalid credentials', 400);
  }

  // Check if the user is blocked
  if ($user['user_is_blocked'] == 1) {
    throw new Exception('Your account is blocked. Please contact support.', 403);
  }

  // Check if the user has been deleted
  if ($user['user_deleted_at'] != 0) {
    throw new Exception('Your account has been deleted and you cannot log in.', 403);
  }

  // Based on the logged-in users information, insert the data into the session (temporary placeholding of the data during login)
  $_SESSION['user'] = [
    'user_id' => $user['user_id'],
    'user_name' => $user['user_name'],
    'user_last_name' => $user['user_last_name'],
    'user_email' => $user['user_email'],
    'user_password' => $user['user_password'],
    'role_id_fk' => $user['role_id_fk'],
    'user_is_blocked' => $user['user_is_blocked']
  ];

  // Convert data into json-objects and display in the session_storage
  http_response_code(200);
  echo json_encode($_SESSION['user']);

}catch(Exception $e){
  try{
    if( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }
      http_response_code($e->getCode());
      echo json_encode(['info'=>$e->getMessage()]);
  }catch(Exception $ex){
    http_response_code(500);
    echo json_encode($ex);    
  }
}
