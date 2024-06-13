<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {

    // Connect to the database
    $db = _db();

    $publicOnly = isset($_GET['public_only']) ? true : false;

    // Prepare the SQL query to fetch cases
    $sql = "SELECT * FROM cases";
    if ($publicOnly) {
        $sql .= " WHERE case_is_public = 1";
    }

    $q = $db->prepare($sql);

    // Execute the query
    $q->execute();

    // Fetch all rows as associative arrays
    $cases = $q->fetchAll(PDO::FETCH_ASSOC);

    // Encode the result as JSON and output it
    echo json_encode($cases);

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