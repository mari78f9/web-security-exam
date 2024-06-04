<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__ . '/../_.php';

try {

  // Checks if there's an exisiting user inside the session ... if not, show error-message that the user is not logged in
  if( ! isset($_SESSION['user']['user_id']) ){
    throw new Exception('user not logged in', 400);
  }

  // Fetches the user_id based on the logged-in user in the session
  $user_id = $_SESSION['user']['user_id'];  

  // Checks if the exisiting data of different informations, 
  // matches with the required specifications of the value (fx string-lenght or speciel-characters)
  _validate_user_name();        // Name-validation function from the master-file 
  _validate_user_last_name();   // Last Name-validation function from the master-file 
  _validate_user_address();     // Address-validation function from the master-file 
  _validate_user_email();       // Email-validation function from the master-file 
  

// Updates the data in the database, based on the user_id, and the new-changed data in the user-info-form
  $db = _db();
  $q = $db->prepare('
  UPDATE users 
  SET user_name = :user_name, 
  user_last_name = :user_last_name,
  user_email = :user_email,
  user_address = :user_address,
  user_updated_at = :time
  WHERE user_id = :user_id
  ');

  // Binds each value of the elements in the query, with each element in the user-info-form
    $q-> bindValue(':user_name', $_POST['user_name']);
    $q-> bindValue(':user_id', $user_id);
    $q-> bindValue(':user_last_name', $_POST['user_last_name']);
    $q-> bindValue(':user_email', $_POST['user_email']);
    $q-> bindValue(':user_address', $_POST['user_address']);
    $q-> bindValue(':time', time());
    $q -> execute();
    $counter = $q->rowCount();

  // If a user doesn't get updated (effected), show error message
  if( $counter != 1 ){
    throw new Exception('could not update user', 500);
  }
  // If a user gets updated, show "User updated"
  http_response_code(200);
  echo json_encode('User updated');

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



