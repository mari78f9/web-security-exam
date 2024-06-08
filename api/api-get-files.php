<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {

    // Connect to the database
    $db = _db();  

    // Check if 'case_id' parameter is present in the GET request
    if (isset($_GET['case_id'])) {

        // Retrieve the case ID from the GET parameters
        $case_id = $_GET['case_id'];

        // Prepare SQL statement to fetch files associated with the given case ID
        $sql = "SELECT * FROM files WHERE case_id_fk = ?";
        $stmt = $db->prepare($sql);

        // Execute the SQL statement with the case ID as parameter
        $stmt->execute([$case_id]);

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
} catch (Exception $e) {  
    
    // Handle exceptions by setting appropriate HTTP response code and returning error message as JSON
    http_response_code($e->getCode() ?: 500);              
    echo json_encode(['info' => $e->getMessage()]);  
}

?>