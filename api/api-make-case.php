<?php
// Include necessary files and configurations
require_once __DIR__.'/../_.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that required fields are present
    if (
        isset($_POST['case_description']) &&
        isset($_POST['case_suspect']) &&
        isset($_POST['case_type']) &&
        isset($_POST['case_location'])
    ) {
        // Extract data from POST request
        $case_description = $_POST['case_description'];
        $case_suspect = $_POST['case_suspect'];
        $case_type = $_POST['case_type'];
        $case_location = $_POST['case_location'];

        // Generate unique case_id
        $case_id = bin2hex(random_bytes(5)); // Generate a random hexadecimal string

        // Insert the case into the database
        try {
            $db = _db();
            $q = $db->prepare('
                INSERT INTO cases (case_id, case_description, case_suspect, case_type, case_location, case_solved, case_created_at, case_updated_at, case_is_public)
                VALUES (:case_id, :description, :suspect, :type, :location, 0, :created_at, 0, 0)
            ');

            // Bind parameters
            $q->bindParam(':case_id', $case_id);
            $q->bindParam(':description', $case_description);
            $q->bindParam(':suspect', $case_suspect);
            $q->bindParam(':type', $case_type);
            $q->bindParam(':location', $case_location);
            $q->bindValue(':created_at', time());

            // Execute the query
            $q->execute();

            // Respond with success message
            http_response_code(201); // Created status code
            echo json_encode(array("message" => "Case created successfully.", "case_id" => $case_id));
        } catch (PDOException $e) {
            // Respond with error message
            http_response_code(500); // Internal Server Error status code
            echo json_encode(array("error" => "Unable to create case. " . $e->getMessage()));
        }
    } else {
        // Respond with error message if required fields are missing
        http_response_code(400); // Bad Request status code
        echo json_encode(array("error" => "Missing required fields."));
    }
} else {
    // Respond with error message if not a POST request
    http_response_code(405); // Method Not Allowed status code
    echo json_encode(array("error" => "Only POST requests are allowed."));
}
?>