<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /../views/error.php");
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if all required fields are provided in the POST data
    if (
        isset($_POST['case_description']) &&
        isset($_POST['case_suspect']) &&
        isset($_POST['case_type']) &&
        isset($_POST['case_location'])
    ) {
     
        // Retrieve and sanitize data from POST parameters
        // Sanitizes the input data using htmlspecialchars() to prevent XSS attacks.
        // ENT_QUOTES and 'UTF-8' are parameters used with the 
        // htmlspecialchars() function in PHP to ensure proper sanitization of input data.
        $case_description = htmlspecialchars($_POST['case_description'], ENT_QUOTES, 'UTF-8');
        $case_suspect = htmlspecialchars($_POST['case_suspect'], ENT_QUOTES, 'UTF-8');
        $case_type = htmlspecialchars($_POST['case_type'], ENT_QUOTES, 'UTF-8');
        $case_location = htmlspecialchars($_POST['case_location'], ENT_QUOTES, 'UTF-8');

         // Validate the sanitized inputs
         // Ensuring that the sanitized input is not empty.
         if (empty($case_description) || empty($case_suspect) || empty($case_type) || empty($case_location)) {
            http_response_code(400); 
            echo json_encode(array("error" => "Invalid input provided."));
            exit;
        }

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
            // Explicitly specifying the parameter types when binding them to the prepared statement 
            // using PDO::PARAM_STR and PDO::PARAM_INT.
            $q->bindParam(':case_id', $case_id, PDO::PARAM_STR);
            $q->bindParam(':description', $case_description, PDO::PARAM_STR);
            $q->bindParam(':suspect', $case_suspect, PDO::PARAM_STR);
            $q->bindParam(':type', $case_type, PDO::PARAM_STR);
            $q->bindParam(':location', $case_location, PDO::PARAM_STR);
            $q->bindValue(':created_at', time(), PDO::PARAM_INT);

            // Execute the prepared statement to insert the case into the database
            $q->execute();

            // Set HTTP response code to indicate successful case creation (201)
            http_response_code(201); 

            // Output JSON response indicating successful case creation and the generated case ID
            echo json_encode(array("message" => "Case created successfully.", "case_id" => $case_id));

        // PDOException handles exceptions specific to PDO operations, such as database connection errors, query execution errors, etc.
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