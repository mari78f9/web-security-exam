<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set response header to indicate JSON content type
header('Content-Type: application/json');

try {
    // Extract user ID and blocked status from POST data
    $user_id = $_POST['user_id'];
    $user_is_blocked = $_POST['user_is_blocked'];

    // Connect to the database
    $db = _db();

    // Prepare SQL query to update user's blocked status and user_updated_at timestamp
    $q = $db->prepare("
        UPDATE users 
        SET user_is_blocked = :user_is_blocked,
            user_updated_at = :user_updated_at
        WHERE user_id = :user_id
    ");

    // Bind values to the prepared statement
    $q->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $q->bindValue(':user_is_blocked', $user_is_blocked, PDO::PARAM_INT);
    $q->bindValue(':user_updated_at', time(), PDO::PARAM_INT); // Update with current timestamp

    // Execute the prepared statement to update user's blocked status and timestamp
    $q->execute();

    // Output success message in JSON format
    echo json_encode(['success' => true, 'info' => 'User updated successfully']);

} catch (PDOException $e) {
    // Handle PDO exceptions (database-related errors)
    http_response_code(500);
    echo json_encode(['error' => 'Database error: '.$e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
