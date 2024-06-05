<?php

if (isset($_GET['case_id'])) {
    // Construct the query based on case_id
    $query = 'case_id=' . $_GET['case_id'];

    // Construct the full URL for the images
    $url = 'http://127.0.0.1/api/api-get-files.php?' . $query;

    // Debugging output
    echo '<h1>Displaying Files for Case ID ' . htmlspecialchars($_GET['case_id']) . '</h1>';

    // Fetch and display the images
    echo '<div>';
    echo '<iframe src="' . $url . '" width="100%" height="600px"></iframe>';
    echo '</div>';
} else {
    echo '<p>No case ID provided.</p>';
}

?>