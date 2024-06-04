<?php

require_once __DIR__.'/../_.php';

try {
    $db = _db();  

    // Check if the request has file_id or file_name
    if (isset($_GET['file_id'])) {
        $file_id = $_GET['file_id'];
        $sql = "SELECT * FROM files WHERE file_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$file_id]);
    } elseif (isset($_GET['file_name'])) {
        $file_name = $_GET['file_name'];
        $sql = "SELECT * FROM files WHERE file_name = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$file_name]);
    } else {
        throw new Exception('No file identifier provided.', 400);
    }

    $file = $stmt->fetch();

    if ($file) {
        header('Content-Type: image/jpeg');
        echo $file['file_object'];
    } else {
        throw new Exception('File not found.', 404);
    }

} catch (Exception $e) {                             
    http_response_code($e->getCode() ?: 500);              
    echo json_encode(['info' => $e->getMessage()]);  
}
?>