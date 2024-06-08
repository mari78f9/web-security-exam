<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php'; 
                                  
try {

    // Extract user ID and blocked status from POST data
    $user_id = $_POST['user_id'];
    $user_is_blocked = $_POST['user_is_blocked']; 

    // Connect to the database
    $db = _db(); 

    // Prepare SQL query to update user's blocked status
    $q = $db->prepare("
        UPDATE users 
        SET user_is_blocked = :user_is_blocked
        WHERE user_id = :user_id;
    ");

    // Bind values to the prepared statement
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':user_is_blocked', $user_is_blocked);

    // Execute the prepared statement to update user's blocked status
    $q->execute();

    // Output success message in JSON format
    echo json_encode(['info' => 'user updated']);
  } catch (Exception $e) {

    // Handle exceptions
    // Determine appropriate status code
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();

    // Determine appropriate error message
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();

    // Set HTTP response code and output error message in JSON format
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}