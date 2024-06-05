<?php

require_once __DIR__.'/../_.php';

try {
    $db = _db();  

    // Check if the request has case_id
    if (isset($_GET['case_id'])) {
        $case_id = $_GET['case_id'];
        $sql = "SELECT * FROM files WHERE case_id_fk = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$case_id]);

        $files = $stmt->fetchAll();
        
        if ($files) {
            foreach ($files as $file) {
                echo '<div>';
                echo '<h2>File Name: ' . htmlspecialchars($file['file_name']) . '</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($file['file_object']) . '" alt="File Image">';
                echo '</div>';
            }
        } else {
            throw new Exception('No files found for the given case ID.', 404);
        }
    } else {
        throw new Exception('No case ID provided.', 400);
    }
} catch (Exception $e) {                             
    http_response_code($e->getCode() ?: 500);              
    echo json_encode(['info' => $e->getMessage()]);  
}

?>