<?php
require_once __DIR__.'/../_.php';
header('Content-Type: application/json');

try {
    $db = _db();

    $publicOnly = isset($_GET['public_only']) ? 'WHERE case_is_public = 1' : '';
    $q = $db->prepare("SELECT * FROM cases $publicOnly");
    $q->execute();

    // Fetch all cases
    $cases = $q->fetchAll(PDO::FETCH_ASSOC);

    // Output the cases in JSON format
    echo json_encode($cases);
} catch (Exception $e) {
    // In case of an error, output a JSON error message
    echo json_encode(['error' => $e->getMessage()]);
}