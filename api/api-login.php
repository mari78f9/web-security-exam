<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response header to indicate JSON content type
header('Content-Type: application/json');

try {

  // Validate user email using function from the master-file
  _validate_user_email();   
  
  // Validate user password using function from the master-file 
  _validate_user_password();

  // Connect to the database
  $db = _db();

  // Prepare SQL query to select user based on email and join with roles to get role_name
  $q = $db->prepare('
    SELECT users.*, roles.role_name 
    FROM users 
    JOIN roles ON users.role_id_fk = roles.role_id 
    WHERE users.user_email = :user_email
  ');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  
  // Fetch the user data
  $user = $q->fetch();

  // If user does not exist, throw an exception
  if ( ! $user ){
    throw new Exception('invalid credentials', 400);
  }

  // Verify if the provided password matches the hashed password stored in the database
  if ( ! password_verify($_POST['user_password'], $user['user_password']) ){
    throw new Exception('invalid credentials', 400);
  }

  // Check if the user account is blocked
  if ($user['user_is_blocked'] == 1) {
    throw new Exception('Your account is blocked. Please contact support.', 403);
  }

  // Check if the user account has been deleted
  if ($user['user_deleted_at'] != 0) {
    throw new Exception('Your account has been deleted and you cannot log in.', 403);
  }

  // Store user information in session
  $_SESSION['user'] = [
    'user_id' => $user['user_id'],
    'user_name' => $user['user_name'],
    'user_last_name' => $user['user_last_name'],
    'user_email' => $user['user_email'],
    'user_password' => $user['user_password'],
    'role_id_fk' => $user['role_id_fk'],
    'role_name' => $user['role_name'],
    'user_is_blocked' => $user['user_is_blocked']
  ];

  // Set HTTP response code to indicate success
  http_response_code(200);

  // Encode user session data as JSON and output it
  echo json_encode($_SESSION['user']);

} catch(Exception $e) {

  // If an exception occurs, handle it
  try {

    // Check if exception code or message is not set
    if ( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }

      // Set HTTP response code based on exception code
      http_response_code($e->getCode());

      // Encode exception message as JSON and output it
      echo json_encode(['info'=>$e->getMessage()]);
  } catch (Exception $ex) {

    // If an exception occurs during exception handling, set HTTP response code to 500 and output the exception
    http_response_code(500);
    echo json_encode($ex);    
  }
}
