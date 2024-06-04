<?php

if (isset($_GET['file_id']) || isset($_GET['file_name'])) {
    $query = isset($_GET['file_id']) ? 'file_id=' . $_GET['file_id'] : 'file_name=' . urlencode($_GET['file_name']);
    $url = '../../api/api-get-files.php?' . $query;

    echo '<h1>Displaying File</h1>';
    echo '<img src="' . $url . '" alt="File Image">';
} else {
    echo '<p>No file identifier provided.</p>';
}

?>