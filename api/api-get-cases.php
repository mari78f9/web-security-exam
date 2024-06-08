<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {

    // Connect to the database
    $db = _db();

    // Check if 'public_only' parameter is present in the GET request
    // If present, filter only public cases, otherwise retrieve all cases
    $publicOnly = isset($_GET['public_only']) ? 'WHERE case_is_public = 1' : '';

    // Prepare the SQL query to fetch cases
    // If 'public_only' is set, add WHERE clause to filter public cases
    $q = $db->prepare("SELECT * FROM cases $publicOnly");

    // Execute the query
    $q->execute();

    // Fetch all rows as associative arrays
    $cases = $q->fetchAll(PDO::FETCH_ASSOC);

    // Encode the result as JSON and output it
    echo json_encode($cases);
} catch (Exception $e) {

    // If an exception occurs, encode the error message as JSON and output it
    echo json_encode(['error' => $e->getMessage()]);
}