<?php
// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Validate user inputs (you might have additional validation functions)
    _validate_user_name();   
    _validate_user_last_name();    
    _validate_user_email();   
    _validate_user_password();    
    _validate_user_confirm_password();     

    // Connect to the database
    $db = _db();    

    // Prepare SQL query to insert a new user into the database
    $q = $db->prepare('
        INSERT INTO users 
        (
            user_id, 
            user_name, 
            user_last_name, 
            user_email, 
            user_password, 
            role_id_fk,
            user_created_at, 
            user_updated_at,
            user_deleted_at,
            user_is_blocked
        ) VALUES (
            :user_id, 
            :user_name, 
            :user_last_name, 
            :user_email, 
            :user_password, 
            :role_id_fk,
            :user_created_at, 
            :user_updated_at,
            :user_deleted_at,
            :user_is_blocked
        )'
    );

    // Generate a random user ID (you might want to adjust this logic as needed)
    $user_id = bin2hex(random_bytes(5));

    // Bind values to the prepared statement with type specifications for security
    $q->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $q->bindValue(':user_name', $_POST['user_name'], PDO::PARAM_STR); 
    $q->bindValue(':user_last_name', $_POST['user_last_name'], PDO::PARAM_STR);
    $q->bindValue(':user_email', $_POST['user_email'], PDO::PARAM_STR);           
    $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT), PDO::PARAM_STR);  
    $q->bindValue(':role_id_fk', 3, PDO::PARAM_INT);
    $q->bindValue(':user_created_at', time(), PDO::PARAM_INT);
    $q->bindValue(':user_updated_at', 0, PDO::PARAM_INT);
    $q->bindValue(':user_deleted_at', 0, PDO::PARAM_INT);
    $q->bindValue(':user_is_blocked', 0, PDO::PARAM_INT);

    // Execute the prepared statement to insert the user into the database
    $q->execute();  

    // Get the number of affected rows
    $counter = $q->rowCount();

    // Check if the insertion was successful
    if ($counter != 1) {
        throw new Exception('Failed to insert user', 500);
    }

    // Return success response with appropriate message and user ID
    echo json_encode(['success' => true, 'user_id' => $user_id]);

} catch (PDOException $e) {
    // Handle PDO exceptions (database-related errors)
    http_response_code(500);
    echo json_encode(['error' => 'Database error: '.$e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
