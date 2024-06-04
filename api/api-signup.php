<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try{

// Checks if the registration of different informations, 
// matches with the required specifications of the value (fx string-lenght or speciel-characters)

  _validate_user_name();                  // Name-validation function from the master-file 
  _validate_user_nickname();                  // Name-validation function from the master-file 
  _validate_user_last_name();             // Last-name-validation function from the master-file
  _validate_user_email();                 // Email-validation function from the master-file 
  _validate_user_password();              // Password-validation function from the master-file 
  _validate_user_confirm_password();      // Confirm-password-validation function from the master-file 


// Creating a variable with the _db() function, containing the database connection, from the master-file
// Prepares SQL statement in the database - creating a new user, required to contain the written user-descriptive values 
  $db = _db();                            
  $q = $db->prepare('
    INSERT INTO users 
    VALUES (
      :user_id, 
      :user_name, 
      :user_nickname
      :user_last_name, 
      :user_email, 
      :user_address,
      :user_password, 
      :user_role, 
      :user_created_at, 
      :user_updated_at,
      :user_deleted_at,
      :user_is_blocked
      )'
  );                                    

  $q->bindValue(':user_id', null);                                                                  // Binds the placeholder value (from the SQL statement in the database) to a NULL (since the user_id is a 'SERIAL' and AUTO INCREMENT the next available id for each new user)
  $q->bindValue(':user_name', $_POST['user_name']);                                                 // Binds the placeholder value (from the SQL statement in the database) to the user_name fetched from the $_POST request
  $q->bindValue(':user_nickname', $_POST['user_nickname']);                                                 // Binds the placeholder value (from the SQL statement in the database) to the user_name fetched from the $_POST request
  $q->bindValue(':user_last_name', $_POST['user_last_name']);                                       // Binds the placeholder value (from the SQL statement in the database) to the user_last_name fetched from the $_POST request
  $q->bindValue(':user_email', $_POST['user_email']);                                               // Binds the placeholder value (from the SQL statement in the database) to the user_email fetched from the $_POST request
  $q->bindValue(':user_address', $_POST['user_address']);                                           // Binds the placeholder value (from the SQL statement in the database) to the user_address fetched from the $_POST request
  // $q->bindValue(':user_password', $_POST['user_password']);              
  $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));        // Binds the placeholder value (from the SQL statement in the database) to the user_password fetched from the $_POST request (which is secured by the password_hash() function)    
  $q->bindValue(':user_role', $_POST['user_role']);                                                 // Binds the placeholder value (from the SQL statement in the database) to the user_role fetched from the $_POST request
  $q->bindValue(':user_created_at', time());                                                        // Binds the placeholder value (from the SQL statement in the database) to the current timestamp from when the user was created
  $q->bindValue(':user_updated_at', 0);                                                             // Binds the placeholder value (from the SQL statement in the database) to the value '0' (the database will simply contain the '0')
  $q->bindValue(':user_deleted_at', 0);                                                             // Binds the placeholder value (from the SQL statement in the database) to the value '0' (the database will simply contain the '0')
  $q->bindValue(':user_is_blocked', 0);                                                             // Binds the placeholder value (from the SQL statement in the database) to the value '0' (the database will simply contain the '0')

  $q->execute();                                                                                    // Executes the statement  
  $counter = $q->rowCount();                                                                        // Creating a variable with function counting the affected rows
  if( $counter != 1 ){                                                                              // If the counter doesn't equal 1
    throw new Exception('ups...', 500);                                                             // ... throw new Exception, showing status-code 500 (server error) saying "Ups..."
  }

  echo json_encode(['user_id' => $db->lastInsertId()]);                                             // Converting the associative array into JSON-objects, showing the newest user_id of the created user (to confirm successfully creation)


}catch(Exception $e){                               // Catches a variable '$e' containing information about the error / unexpected behaviour
  try{
    if( ! ctype_digit($e->getCode())){              // If the exception-code doesn't ONLY contain digits
      throw new Exception();                        // ... throw new Exception
    }
    http_response_code($e->getCode());              // ...with the error/unexpected behavioured code
    echo json_encode(['info'=>$e->getMessage()]);   // ...including the message
  }catch(Exception $ex){                            // Catches a NEW variable '$ex' containing NEW information about the NEW error / unexpected behaviour
    http_response_code(500);                        // ... show a response-code 500(server error) including the exception information
    echo json_encode(['info'=>json_encode($ex)]);
  }
}




