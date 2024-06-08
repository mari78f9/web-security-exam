<?php 
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {
  // Checks if the user is logged in
  if (!isset($_SESSION['user']['user_id'])) {
      throw new Exception('User not logged in', 400);
  }

  // Fetches the user_id from the request (assuming user_id is passed in the POST request)
  if (!isset($_POST['user_id'])) {
      throw new Exception('User ID is required', 400);
  }
  $user_id = $_POST['user_id'];

  // Updates the user_deleted_at column to mark the user as deleted with the current epoch time
  $db = _db();
  $q = $db->prepare('
      UPDATE users SET user_deleted_at = :user_deleted_at WHERE user_id = :user_id
  ');

  $q->bindValue(':user_id', $user_id);
  $q->bindValue(':user_deleted_at', time());
  $q->execute();
  $counter = $q->rowCount();

  if ($counter != 1) {
      throw new Exception('Could not delete user', 500);
  }

  http_response_code(200);
  echo json_encode(['info' => 'User deleted']);
} catch (Exception $e) {
  http_response_code($e->getCode() ?: 500);
  echo json_encode(['info' => $e->getMessage()]);
}

// try{

//   // Checks if there's an exisiting user inside the session
//   if( ! isset($_SESSION['user']['user_id']) ){
//     throw new Exception('user not logged in', 400);
//   }

//   // Fetches the user_id based on the logged-in user in the session
//   $user_id = $_SESSION['user']['user_id'];


//   // Deletes the entire user in the database, based on the user_id
//   $db = _db();
//   $q = $db->prepare('
//     DELETE FROM users WHERE user_id = :user_id
//   ');

//   // Binds the value of the user_id in the query, with the user_id in the session
//   $q->bindValue(':user_id', $user_id);
//   $q->execute();
//   $counter = $q->rowCount();

//   // If a user doesn't get deleted (effected), show error message
//   if( $counter != 1 ){
//     throw new Exception('could not delete user', 500);
//   }
//   // If a user gets deleted, show the related HTTP-code and 'confirm message'
//   http_response_code(204);
//   echo json_encode('User deleted');

// }catch(Exception $e){
//   try{
//     if( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }
//     http_response_code($e->getCode());
//     echo json_encode(['info'=>$e->getMessage()]);
//   }catch(Exception $ex){
//     http_response_code(500);
//     echo json_encode($ex); 
//   }
// }