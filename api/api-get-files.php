<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {

    // Connect to the database
    $db = _db();  

    // Check if 'case_id' parameter is present in the GET request
    if (isset($_SESSION['current_case_id'])) {

        // Retrieve the case ID from the GET parameters
        // $case_id = $_GET['case_id'];
        $case_id = $_SESSION['current_case_id'];

        // Prepare SQL statement to fetch files associated with the given case ID
        $sql = "SELECT * FROM files WHERE case_id_fk = :case_id";
        $stmt = $db->prepare($sql);

        // Bind the case_id parameter securely
        // PDO::PARAM_INT = ensures that the value is interpreted correctly by the database engine,
        // but also helps prevent SQL injection by explicitly defining the expected data type.
        $stmt->bindValue(':case_id', $case_id, PDO::PARAM_INT);

        // Execute the SQL statement
        $stmt->execute();

        // Fetch all rows returned by the query
        $files = $stmt->fetchAll();
        
        // Check if any files were found
        if ($files) {

            // Loop through each file and display its details
            foreach ($files as $file) {
                echo '<div>';
                echo '<h2>File Name: ' . htmlspecialchars($file['file_name']) . '</h2>';

                // Display the file image using base64 encoding
                echo '<img src="data:image/jpeg;base64,' . base64_encode($file['file_object']) . '" alt="File Image">';
                echo '</div>';
            }
        } else {

            // If no files were found, display a message
            echo 'No files found for the given case ID.';
        }
    } else {

        // If 'case_id' parameter is not provided, throw an exception
        throw new Exception('No case ID provided.', 400);
    }

// PDOException handles exceptions specific to PDO operations, such as database connection errors, query execution errors, etc.
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