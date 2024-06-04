<?php

require_once __DIR__.'/../_.php';

try{
    $db = _db();  

    if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_POST['file_name'];
        handleFileUpload($file_name, $_FILES['file']);
    } else {
        throw new Exception('No file was uploaded.', 400);
    }

    // echo json_encode(['user_id' => $db->lastInsertId()]);
}catch(Exception $e){                             
    try{
        if(!ctype_digit($e->getCode())){           
            throw new Exception();                       
        }
        http_response_code($e->getCode());              
        echo json_encode(['info'=>$e->getMessage()]);  
    }catch(Exception $ex){                           
        http_response_code(500);                       
        echo json_encode(['info'=>json_encode($ex)]);
    }
}

// Function to handle file uploads
function handleFileUpload($file_name, $file){
    $db = _db();
    $file_object = file_get_contents($file['tmp_name']);
    $sql = "INSERT INTO files (file_name, file_object) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$file_name, $file_object]);
}