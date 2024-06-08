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