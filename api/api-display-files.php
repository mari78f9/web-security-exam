<?php

// Check if 'case_id' is present in the GET request
if (isset($_GET['case_id'])) {

    // Construct the query string using the provided 'case_id'
    $query = 'case_id=' . $_GET['case_id'];

    // Construct the full URL for fetching the images
    $url = 'http://127.0.0.1/api/api-get-files.php?' . $query;

    // Debugging output: Display the case ID being used
    echo '<h1>Displaying Files for Case ID ' . htmlspecialchars($_GET['case_id']) . '</h1>';

    // Display the images using an iframe
    echo '<div>';
    echo '<iframe src="' . $url . '" width="100%" height="600px"></iframe>';
    echo '</div>';
} else {

    // If 'case_id' is not provided, display an error message
    echo '<p>No case ID provided.</p>';
}

?>