<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

try {

    // Connect to the database
    $db = _db();  

    // Check if a file was uploaded and there were no errors
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {

        // Check if file name and case ID are provided
        if (isset($_POST['file_name']) && isset($_POST['case_id']) && !empty($_POST['case_id'])) {
            $file_name = $_POST['file_name'];
            $case_id_fk = $_POST['case_id'];

            // Call function to handle file upload
            handleFileUpload($file_name, $_FILES['file'], $case_id_fk);
        } else {
            throw new Exception('File name or case ID is missing.', 400);
        }
    } else {
        throw new Exception('No file was uploaded.', 400);
    }
} catch(Exception $e) {  
    
    // Handle exceptions
    try {

        // Check if the exception has a numeric code
        if (!ctype_digit($e->getCode())){           
            throw new Exception();                       
        }

        // Set HTTP response code to the exception code
        http_response_code($e->getCode());   
        
        // Output error message in JSON format
        echo json_encode(['info'=>$e->getMessage()]);  
    } catch(Exception $ex) {  
        
        // Set HTTP response code to 500 (Internal Server Error)
        http_response_code(500);    
        
        // Output error message in JSON format
        echo json_encode(['info'=>json_encode($ex)]);
    }
}

// Function to handle file upload
function handleFileUpload($file_name, $file, $case_id_fk){

    // Connect to the database
    $db = _db();

    // Read file contents
    $file_object = file_get_contents($file['tmp_name']);
    
    // Check if the case ID exists in the database
    $case_check_sql = "SELECT 1 FROM cases WHERE case_id = ?";
    $case_check_stmt = $db->prepare($case_check_sql);
    $case_check_stmt->execute([$case_id_fk]);
    
    // If the case ID exists, insert file information into the database
    if ($case_check_stmt->fetch()) {
        $sql = "INSERT INTO files (file_name, file_object, case_id_fk) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$file_name, $file_object, $case_id_fk]);
    } else {

        // If the case ID does not exist, throw an exception
        throw new Exception('Case ID does not exist.', 400);
    }
}

?>