<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__ . '/../_.php';

try {

  // Check if the user is logged in
  if ( ! isset($_SESSION['user']['user_id']) ) {
    throw new Exception('user not logged in', 400);
  }

  // Get the user ID from the session
  $user_id = $_SESSION['user']['user_id'];  

  // Validate user name using function from the master-file
  _validate_user_name();   
  
  // Validate user last name using function from the master-file
  _validate_user_last_name();    
  
  // Validate user email using function from the master-file
  _validate_user_email();   

  // Connect to the database
  $db = _db();

  // Prepare the SQL query to update user information
  $q = $db->prepare('
    UPDATE users 
    SET user_name = :user_name, 
    user_last_name = :user_last_name,
    user_email = :user_email,
    role_id_fk = :role_id_fk,
    user_updated_at = :time,
    WHERE user_id = :user_id
  ');

  // Bind parameters to the prepared statement
  $q-> bindValue(':user_name', $_POST['user_name']);
  $q-> bindValue(':user_id', $user_id);
  $q-> bindValue(':user_last_name', $_POST['user_last_name']);
  $q-> bindValue(':user_email', $_POST['user_email']);
  $q-> bindValue(':role_id_fk', $_POST['role_id_fk']);
  $q-> bindValue(':time', time());

  // Execute the query
  $q -> execute();

  // Get the number of affected rows
  $counter = $q->rowCount();

  // Check if the user was successfully updated
  if ( $counter != 1 ) {
    throw new Exception('could not update user', 500);
  }

  // Set HTTP response code to 200 (OK)
  http_response_code(200);

  // Output success message in JSON format
  echo json_encode('User updated');

} catch(Exception $e) {

  // Handle exceptions
  try {

    // Check if the exception has a code and message
    if ( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }

    // Set HTTP response code to the exception code
    http_response_code($e->getCode());

    // Output error message in JSON format
    echo json_encode(['info'=>$e->getMessage()]);
  } catch(Exception $ex) {

    // Set HTTP response code to 500 (Internal Server Error)
    http_response_code(500);

    // Output error message in JSON format
    echo json_encode($ex); 
  }
}