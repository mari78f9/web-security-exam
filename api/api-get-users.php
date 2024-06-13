<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response header to indicate JSON content type
header('Content-Type: application/json');

try {

    // Connect to the database
    $db = _db();

    // Prepare SQL query to select all users where user_deleted_at is 0 (not deleted)
    $q = $db->prepare('SELECT * FROM users WHERE user_deleted_at = 0');

    // Execute the query
    $q->execute();

    // Fetch all rows returned by the query
    $users = $q->fetchAll();

    // Set HTTP response code to indicate success
    http_response_code(200);

    // Encode the user data as JSON and output it
    echo json_encode($users);
} catch (Exception $e) {

    // If an exception occurs, set HTTP response code to indicate server error
    http_response_code(500);

    // Encode the error message as JSON and output it
    echo json_encode(['info' => $e->getMessage()]);
}