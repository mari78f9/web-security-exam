<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {

  // Validate user name using function from the master-file
  _validate_user_name();   
  
  // Validate user last name using function from the master-file
  _validate_user_last_name();    
  
  // Validate user email using function from the master-file
  _validate_user_email();   
  
  // Validate user password using function from the master-file
  _validate_user_password();    
  
  // Validate user confirm password using function from the master-file
  _validate_user_confirm_password();     

  // Connect to the database
  $db = _db();    
  
  // Prepare SQL query to insert a new user into the database
  $q = $db->prepare('
    INSERT INTO users 
    VALUES (
      :user_id, 
      :user_name, 
      :user_last_name, 
      :user_email, 
      :user_password, 
      :role_id_fk,
      :user_created_at, 
      :user_updated_at,
      :user_deleted_at,
      :user_is_blocked
      )'
  );                                    

  // Generate a random user ID
  $q->bindValue(':user_id', bin2hex(random_bytes(5)));

  // Bind values to the prepared statement
  $q->bindValue(':user_name', $_POST['user_name']); 
  $q->bindValue(':user_last_name', $_POST['user_last_name']);
  $q->bindValue(':user_email', $_POST['user_email']);           
  $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));  
  $q->bindValue(':role_id_fk', 3);
  $q->bindValue(':user_created_at', time());
  $q->bindValue(':user_updated_at', 0);
  $q->bindValue(':user_deleted_at', 0);
  $q->bindValue(':user_is_blocked', 0);

  // Execute the prepared statement to insert the user into the database
  $q->execute();  

  // Get the number of affected rows
  $counter = $q->rowCount();

  // Check if the insertion was successful
  if ( $counter != 1 ) {
    throw new Exception('ups...', 500);
  }

  // Output the user ID of the newly inserted user
  echo json_encode(['user_id' => $db->lastInsertId()]);


} catch(Exception $e) {
  try {

    // If the exception code is not numeric, throw another exception
    if ( ! ctype_digit($e->getCode())) {
      throw new Exception();
    }

    // Set HTTP response code and output error message
    http_response_code($e->getCode());
    echo json_encode(['info'=>$e->getMessage()]); 
  } catch (Exception $ex) { 
    // If another exception occurs, set HTTP response code to 500 and output error message
    http_response_code(500);
    echo json_encode(['info'=>json_encode($ex)]);
  }
}