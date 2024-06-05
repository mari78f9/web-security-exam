<?php

require_once __DIR__.'/../_.php';

try{
    $db = _db();  

    if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        if (isset($_POST['file_name']) && isset($_POST['case_id']) && !empty($_POST['case_id'])) {
            $file_name = $_POST['file_name'];
            $case_id_fk = $_POST['case_id'];
            handleFileUpload($file_name, $_FILES['file'], $case_id_fk);
        } else {
            throw new Exception('File name or case ID is missing.', 400);
        }
    } else {
        throw new Exception('No file was uploaded.', 400);
    }
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
function handleFileUpload($file_name, $file, $case_id_fk){
    $db = _db();
    $file_object = file_get_contents($file['tmp_name']);
    
    // Verify if the case_id_fk exists in the cases table
    $case_check_sql = "SELECT 1 FROM cases WHERE case_id = ?";
    $case_check_stmt = $db->prepare($case_check_sql);
    $case_check_stmt->execute([$case_id_fk]);
    
    if ($case_check_stmt->fetch()) {
        $sql = "INSERT INTO files (file_name, file_object, case_id_fk) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$file_name, $file_object, $case_id_fk]);
    } else {
        throw new Exception('Case ID does not exist.', 400);
    }
}

?>