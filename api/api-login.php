<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response header to indicate JSON content type
header('Content-Type: application/json');

try {

   // Validate CSRF token
   if (!is_csrf_valid()) {
    throw new Exception('CSRF token validation failed', 403);
  }

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

  // PDO::PARAM_STR is used to explicitly bind the email as a string. 
  // This ensures that the data type is correctly interpreted by the database engine.
  $q->bindValue(':user_email', $_POST['user_email'], PDO::PARAM_STR);
  $q->execute();
  
  // Fetch the user data
  // PDO::FETCH_ASSOC to fetch the user data ensures that an associative array is returned, which is more readable and secure.
  $user = $q->fetch(PDO::FETCH_ASSOC);

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

// PDOException handles exceptions specific to PDO operations, such as database connection errors, query execution errors, etc.
} catch (PDOException $e) {

  // Handle PDO exceptions (database-related errors)
  http_response_code(500);
  echo json_encode(['info' => 'Database error: '.$e->getMessage()]);
} catch (Exception $e) {
  
  // Handle other exceptions
  http_response_code($e->getCode() ?: 500);
  echo json_encode(['info' => $e->getMessage()]);
}
