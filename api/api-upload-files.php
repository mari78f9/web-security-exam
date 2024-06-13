<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Function to handle file upload
function handleFileUpload($file_name, $file, $case_id) {
    // Connect to the database
    $db = _db();

    // Check if the case ID exists in the database
    $case_check_sql = "SELECT 1 FROM cases WHERE case_id = ?";
    $case_check_stmt = $db->prepare($case_check_sql);
    $case_check_stmt->execute([$case_id]);

    // If the case ID exists, insert file information into the database
    if ($case_check_stmt->fetch()) {
        $file_object = file_get_contents($file['tmp_name']);
        $sql = "INSERT INTO files (file_name, file_object, case_id_fk) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$file_name, $file_object, $case_id]);
    } else {
        // If the case ID does not exist, throw an exception
        throw new Exception('Case ID does not exist.', 400);
    }
}

header('Content-Type: application/json');

try {
    // Check if a file was uploaded and there were no errors
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Check if file name and case ID are provided
        if (isset($_POST['file_name']) && isset($_POST['case_id']) && !empty($_POST['case_id'])) {
            $file_name = $_POST['file_name'];
            $case_id_fk = $_POST['case_id'];

            // Call function to handle file upload
            handleFileUpload($file_name, $_FILES['file'], $case_id_fk);
            http_response_code(200);
            echo json_encode(['info' => 'File uploaded successfully.']);
        } else {
            http_response_code(400);
            echo json_encode(['info' => 'File name or case ID is missing.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['info' => 'No file was uploaded.']);
    }
} catch(Exception $e) {
    // Set HTTP response code to the exception code or 500
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['info' => $e->getMessage()]);
}

?>