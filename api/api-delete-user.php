<?php 

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {

  // Check if the user is logged in by verifying if the user ID is set in the session
  if (!isset($_SESSION['user']['user_id'])) {
      throw new Exception('User not logged in', 400);
  }

  // Check if the user ID is provided in the POST request
  if (!isset($_POST['user_id'])) {
      throw new Exception('User ID is required', 400);
  }

  // Get the user ID from the POST request
  $user_id = $_POST['user_id'];

  // Connect to the database
  $db = _db();

  // Prepare an SQL statement to update the user's deletion timestamp
  $q = $db->prepare('
      UPDATE users SET user_deleted_at = :user_deleted_at WHERE user_id = :user_id
  ');

  // Bind the user ID and current time to the SQL statement
  $q->bindValue(':user_id', $user_id);
  $q->bindValue(':user_deleted_at', time());

  // Execute the SQL statement
  $q->execute();

  // Get the number of rows affected by the SQL statement
  $counter = $q->rowCount();

  // If no rows were affected, throw an exception indicating the user could not be deleted
  if ($counter != 1) {
      throw new Exception('Could not delete user', 500);
  }

  // If the operation was successful, set the HTTP response code to 200 and return a success message
  http_response_code(200);
  echo json_encode(['info' => 'User deleted']);
} catch (Exception $e) {

  // If an exception occurs, set the HTTP response code to the exception code or 500 if not specified
  http_response_code($e->getCode() ?: 500);

  // Return the exception message as a JSON response
  echo json_encode(['info' => $e->getMessage()]);
}