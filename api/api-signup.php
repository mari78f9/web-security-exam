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
    (
      user_id, 
      user_name, 
      user_last_name, 
      user_email, 
      user_password, 
      role_id_fk,
      user_created_at, 
      user_updated_at,
      user_deleted_at,
      user_is_blocked
    ) VALUES (
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

  // Bind values to the prepared statement with type specifications for additional security
  // bindValue ensures that the values are properly bound according to their types
  // PDO::PARAM_STR for strings, PDO::PARAM_INT for integers). This prevents any type-related vulnerabilities.
  $q->bindValue(':user_name', $_POST['user_name'], PDO::PARAM_STR); 
  $q->bindValue(':user_last_name', $_POST['user_last_name'], PDO::PARAM_STR);
  $q->bindValue(':user_email', $_POST['user_email'], PDO::PARAM_STR);           
  $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT), PDO::PARAM_STR);  
  $q->bindValue(':role_id_fk', 3, PDO::PARAM_INT);
  $q->bindValue(':user_created_at', time(), PDO::PARAM_INT);
  $q->bindValue(':user_updated_at', 0, PDO::PARAM_INT);
  $q->bindValue(':user_deleted_at', 0, PDO::PARAM_INT);
  $q->bindValue(':user_is_blocked', 0, PDO::PARAM_INT);

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