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
    // Connect to the database
    $db = _db();

    // Check if there is a search query
    $searchQuery = isset($_GET['searchCase']) ? $_GET['searchCase'] : '';
    // Check if public_only parameter is set
    $publicOnly = isset($_GET['public_only']) ? true : false;

    // Prepare the SQL query to fetch cases
    $sql = "SELECT * FROM cases";
    $conditions = [];

    if ($searchQuery) {
        $conditions[] = "case_id LIKE :case_id";
    }

    if ($publicOnly) {
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
