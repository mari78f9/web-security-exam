<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Check if 'case_id' is present in the GET request
if (isset($_GET['case_id'])) {

    // Validate that $_GET['case_id'] is a valid hexadecimal string
    $case_id = $_GET['case_id'];
    $_SESSION['current_case_id'] = $case_id;

    if (!ctype_xdigit($case_id) || strlen($case_id) !== 10) {
        
        // Handle invalid case_id format
        echo '<p class="error-files"> Invalid case ID provided.</p>';
        exit; // Stop further execution
    }

    // // Construct the query string using the provided 'case_id'
    // $query = 'case_id=' . htmlspecialchars($case_id);

    // Construct the full URL for fetching the images

    // $url = 'http://127.0.0.1/api/api-get-files.php?';    // For windows
    $url = 'http://localhost:8888/api/api-get-files.php?';  // For mac

    echo '<p class="display-files-header"> Files provided for Case ' . htmlspecialchars($case_id) . '</p>';
    
    // Debugging output: Display the case ID being used
    echo '<div class="display-files">';
        // Display the images using an iframe
        echo '<div class="files">';
        echo '<iframe src="' . $url . '" ></iframe>';
        echo '</div>';

    echo '</div>';

} else {

    // If 'case_id' is not provided, display an error message
    echo '<p class="error-files"> Please provide a case-id... </p>';
}

?>