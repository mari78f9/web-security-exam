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
  // Using PDO::PARAM_* constants in bindValue is a good practice to ensure the correct data types are used and to enhance security. 
  $q-> bindValue(':user_name', $_POST['user_name'], PDO::PARAM_STR);
  $q-> bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $q-> bindValue(':user_last_name', $_POST['user_last_name'], PDO::PARAM_STR);
  $q-> bindValue(':user_email', $_POST['user_email'], PDO::PARAM_STR);
  $q-> bindValue(':role_id_fk', $_POST['role_id_fk'], PDO::PARAM_STR);
  $q-> bindValue(':time', time(), PDO::PARAM_INT);

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

// PDOException handles exceptions specific to PDO operations, such as database connection errors, query execution errors, etc.
} catch (PDOException $e) {

  // Handle database-related exceptions
  http_response_code(500);
  echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);

} catch (Exception $e) {

  // Handle general exceptions
  http_response_code($e->getCode() ?: 500);
  echo json_encode(['error' => $e->getMessage()]);
}