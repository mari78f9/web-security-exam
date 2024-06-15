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

            echo '<div style="display: grid; grid-template-columns: 1fr 1fr 1fr">';

                // Loop through each file and display its details
                foreach ($files as $file) {
                    echo '<div style="position: relative;">';
                        echo '<div style="position: relative; margin-right: 2rem;">'; // Container div with relative positioning
                        echo '<p style="z-index: 3000; font-size: 20px; color: #ffffff; position: absolute; bottom: 0; padding-left: 1rem;">' . htmlspecialchars($file['file_name']) . '</p>';

                        // Display the file image using base64 encoding with an overlay
                        echo '<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)); z-index: 1000;"></div>';
                        echo '<img style="max-width: 100%; display: block;" src="data:image/jpeg;base64,' . base64_encode($file['file_object']) . '" alt="File Image">';
                        echo '</div>';
                    
                    echo '</div>';
                }
         
            echo '</div>';
            
        } else {

            // If no files were found, display a message
            echo ' <div style=" color: #ffffff;"> No files found relevant to case ' . htmlspecialchars($case_id) . ' </div>';
        }
    } else {

        // If 'case_id' parameter is not provided, throw an exception
        throw new Exception(' <div class="file-error"> No case-id provided </div>', 400);
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