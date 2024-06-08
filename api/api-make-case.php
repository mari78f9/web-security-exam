<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if all required fields are provided in the POST data
    if (
        isset($_POST['case_description']) &&
        isset($_POST['case_suspect']) &&
        isset($_POST['case_type']) &&
        isset($_POST['case_location'])
    ) {
     
        // Retrieve data from POST parameters
        $case_description = $_POST['case_description'];
        $case_suspect = $_POST['case_suspect'];
        $case_type = $_POST['case_type'];
        $case_location = $_POST['case_location'];

        // Generate a random case ID
        $case_id = bin2hex(random_bytes(5));

        try {

            // Connect to the database
            $db = _db();

            // Prepare SQL query to insert a new case into the database
            $q = $db->prepare('
                INSERT INTO cases (case_id, case_description, case_suspect, case_type, case_location, case_solved, case_created_at, case_updated_at, case_is_public)
                VALUES (:case_id, :description, :suspect, :type, :location, 0, :created_at, 0, 0)
            ');

            // Bind parameters to the prepared statement
            $q->bindParam(':case_id', $case_id);
            $q->bindParam(':description', $case_description);
            $q->bindParam(':suspect', $case_suspect);
            $q->bindParam(':type', $case_type);
            $q->bindParam(':location', $case_location);
            $q->bindValue(':created_at', time());

            // Execute the prepared statement to insert the case into the database
            $q->execute();

            // Set HTTP response code to indicate successful case creation (201)
            http_response_code(201); 

            // Output JSON response indicating successful case creation and the generated case ID
            echo json_encode(array("message" => "Case created successfully.", "case_id" => $case_id));
        } catch (PDOException $e) {
         
            // If an exception occurs during database operation, set HTTP response code to 500 and output error message
            http_response_code(500); 
            echo json_encode(array("error" => "Unable to create case. " . $e->getMessage()));
        }
    } else {
    
        // If required fields are missing in the POST data, set HTTP response code to 400 and output error message
        http_response_code(400); 
        echo json_encode(array("error" => "Missing required fields."));
    }
} else {
  
    // If the request method is not POST, set HTTP response code to 405 and output error message
    http_response_code(405); 
    echo json_encode(array("error" => "Only POST requests are allowed."));
}
?>