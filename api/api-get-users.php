<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /views/error.php");
    exit();
}

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    $db = _db();

    $searchQuery = isset($_GET['searchUser']) ? trim($_GET['searchUser']) : '';

    if ($searchQuery) {
        $q = $db->prepare('
            SELECT u.*, r.role_name 
            FROM users u 
            LEFT JOIN roles r ON u.role_id_fk = r.role_id 
            WHERE u.user_id LIKE :user_id AND u.user_deleted_at = 0
        ');
        $q->bindValue(':user_id', "%$searchQuery%");
    } else {
        $q = $db->prepare('
            SELECT u.*, r.role_name 
            FROM users u 
            LEFT JOIN roles r ON u.role_id_fk = r.role_id 
            WHERE u.user_deleted_at = 0
        ');
    }

    $q->execute();
    $users = $q->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($users);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['info' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['info' => 'Unexpected error: ' . $e->getMessage()]);
}

?>
