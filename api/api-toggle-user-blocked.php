<?php
require_once __DIR__.'/../_.php';   // Ensures that the '_.php' is included ONLY once - already included elsewhere? Won't be included again...
                                    // __DIR__ = Magic constant - representing the directory of the current script, used to construct absolute path

try{

  $user_id = $_GET['user_id'];                      // Creating variable containing the user_id fetched from a $_GET request
  $user_is_blocked = $_GET['user_is_blocked'];      // Creating variable containing the user_is_blocked fetched from a $_GET request

  $db = _db();                                      // Creating a variable with the _db() function, containing the database connection, from the master-file 
  $q = $db->prepare("
    UPDATE users 
    SET user_is_blocked = !user_is_blocked 
    WHERE user_id = :user_id; 
  ");                                               // Prepares SQL statement in the database - updating the specific user, based on (fetched by) the user_id, whether they're blocked or not

  $q->bindValue(':user_id', $user_id);              // Binds the placeholder value (from the SQL statement in the database) to the user_id fetched from the $_GET request (line 9)
  $q->execute();                                    // Executes the statement 

  echo json_encode(['info'=>'user updated']);       // Converting the associative array into JSON-objects, saying "Info: User updated"


// Checks if the output ONLY contains a number (digit), if not show an error-message
}catch(Exception $e){                                                                             
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();                             // Ternary operator (inside a variable): If the exception-code doesn't ONLY contain digits - return status-code 500 (server error) - or else show exception with the error code
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();       // Ternary operator (inside a variable): If the
    http_response_code($status_code);                                                             // ... show a response-code 500(server error) including the exception information (based on the variable from line 25)
    echo json_encode(['info'=>$message]);                                                         // Converting the associative array into JSON-objects, saying "Info: (info from the variable in line 26)"
}