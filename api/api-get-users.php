<?php
require_once __DIR__.'/../_.php';
header('Content-Type: application/json');

try {
    $db = _db();
    $q = $db->prepare('SELECT * FROM users WHERE user_deleted_at = 0');
    $q->execute();
    $users = $q->fetchAll();

    http_response_code(200);
    echo json_encode($users);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['info' => $e->getMessage()]);
}

// try {
//     $db = _db();

//     // Prepare and execute the query to select all cases
//     $q = $db->prepare('SELECT * FROM users');
//     $q->execute();

//     // Fetch all cases
//     $cases = $q->fetchAll(PDO::FETCH_ASSOC);

//     // Output the cases in JSON format
//     echo json_encode($cases);
// } catch (Exception $e) {
//     // In case of an error, output a JSON error message
//     echo json_encode(['error' => $e->getMessage()]);
// }