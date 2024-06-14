<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Connect to the database
    $db = _db();

    // Check if there is a search query or a public only flag
    $searchQuery = isset($_GET['searchCase']) ? $_GET['searchCase'] : '';
    $publicOnly = isset($_GET['public_only']) ? true : false;

    // Prepare the SQL query
    $sql = "SELECT * FROM cases";
    $conditions = [];

    if ($searchQuery) {
        $conditions[] = "case_id LIKE :case_id";
    }

    // Check if user is a citizen
    $userRole = isset($_SESSION['role_id_fk']) ? $_SESSION['role_id_fk'] : null;
    if ($userRole === 3 && $publicOnly) {
        // If user is a citizen and requesting only public cases
        $conditions[] = "case_is_public = 1";
    }

    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $q = $db->prepare($sql);

    // Bind the search query parameter if it exists
    if ($searchQuery) {
        $q->bindValue(':case_id', "%$searchQuery%");
    }

    // Execute the query
    $q->execute();

    // Fetch all rows as associative arrays
    $cases = $q->fetchAll(PDO::FETCH_ASSOC);

    // Encode the result as JSON and output it
    echo json_encode($cases);

} catch (PDOException $e) {
    // Handle PDO exceptions (database-related errors)
    http_response_code(500);
    echo json_encode(['info' => 'Database error: '.$e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['info' => $e->getMessage()]);
}
?>
