<?php
require_once __DIR__.'/../_.php'; 
                                  
try {

    $user_id = $_POST['user_id']; // Fetch user_id from POST request
    $user_is_blocked = $_POST['user_is_blocked']; // Fetch user_is_blocked from POST request

    $db = _db(); // Get the database connection
    $q = $db->prepare("
        UPDATE users 
        SET user_is_blocked = :user_is_blocked
        WHERE user_id = :user_id;
    ");
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':user_is_blocked', $user_is_blocked);
    $q->execute();

    echo json_encode(['info' => 'user updated']);
  } catch (Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}