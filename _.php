<?php

// *Turns the engine on* ... always ... since the masterfile is included on all pages
session_start();

// Enables the displays of errors and warnings in the browser (1 = true, 0 = false)
// ini_set = changes the value of a configuration option
ini_set('display_errors', 1);
//ini_set('display_errors', 0) = hide error message 


// ##############################
// The Database connection

function _db(){
	try{

    // Variables setting the "login-values" of the database, including the host, db-name and character-set
    $user_name = "root";
    $user_password = "root";
	  $db_connection = "mysql:host=localhost; dbname=web-dev-exam; charset=utf8mb4";
	
	  // Array of configuration-options for the PDO-connection (PHP Data Objects)
    // Sets errormode to throw exceptions (in case of DB-errors), and sets fetch mode to be associative arrays
	  $db_options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // [['id'=>1, 'name'=>'A'],[]]  $user['id']
	  );

    // Returns new PHP Data Objects – 
	  return new PDO( $db_connection, $user_name, $user_password, $db_options );

  // If error occurs during db-connection, send back an error-message with a server-http-code
	}catch( PDOException $e){
	  throw new Exception('ups... system under maintainance', 500);
	  exit();
	}	
}


// ##############################
// Validator of the User Name

define('USER_NAME_MIN', 2);
define('USER_NAME_MAX', 20);
function _validate_user_name(){

  $error = 'user_name min '.USER_NAME_MIN.' max '.USER_NAME_MAX;

  if(!isset($_POST['user_name'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_name'] = trim($_POST['user_name']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_name']) < USER_NAME_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_name']) > USER_NAME_MAX ){
    throw new Exception($error, 400);
  }
}


define('USER_NICKNAME_MIN', 2);
define('USER_NICKNAME_MAX', 20);
function _validate_user_nickname(){

  $error = 'user_name min '.USER_NICKNAME_MIN.' max '.USER_NICKNAME_MAX;

  if(!isset($_POST['user_name'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_name'] = trim($_POST['user_name']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_name']) < USER_NICKNAME_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_name']) > USER_NICKNAME_MAX ){
    throw new Exception($error, 400);
  }
}




// ##############################
define('USER_LAST_NAME_MIN', 2);
define('USER_LAST_NAME_MAX', 20);
function _validate_user_last_name(){

  $error = 'user_last_name min '.USER_LAST_NAME_MIN.' max '.USER_LAST_NAME_MAX;

  if(!isset($_POST['user_last_name'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_last_name'] = trim($_POST['user_last_name']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX ){
    throw new Exception($error, 400);
  }
}
define('USER_USERNAME_MIN', 6);
define('USER_USERNAME_MAX', 50);
function _validate_user_username(){

  $error = 'user_username min '.USER_USERNAME_MIN.' max '.USER_USERNAME_MAX;

  if(!isset($_POST['user_username'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_username'] = trim($_POST['user_username']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_username']) < USER_USERNAME_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_username']) > USER_USERNAME_MAX ){
    throw new Exception($error, 400);
  }
}
define('USER_ADDRESS_MIN', 6);
define('USER_ADDRESS_MAX', 50);
function _validate_user_address(){

  $error = 'user_address min '.USER_ADDRESS_MIN.' max '.USER_ADDRESS_MAX;

  if(!isset($_POST['user_address'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_address'] = trim($_POST['user_address']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_address']) < USER_ADDRESS_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_address']) > USER_ADDRESS_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_email(){
  $error = 'user_email invalid';
  if(!isset($_POST['user_email'])){ 
    throw new Exception($error, 400); 
  }
  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_email'] = trim($_POST['user_email']); 

  // filter_var = used to filter and validate data
  if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
    throw new Exception($error, 400); 
  }
}

// ##############################
define('USER_PASSWORD_MIN', 6);
define('USER_PASSWORD_MAX', 50);

function _validate_user_password(){

  $error = 'user_password min '.USER_PASSWORD_MIN.' max '.USER_PASSWORD_MAX;

  if(!isset($_POST['user_password'])){ 
    throw new Exception($error, 400); 
  }

  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_password'] = trim($_POST['user_password']);

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_password']) < USER_PASSWORD_MIN ){
    throw new Exception($error, 400);
  }

  // strlen = returns the lenght of the string 
  if( strlen($_POST['user_password']) > USER_PASSWORD_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_confirm_password(){
  $error = 'user_confirm_password must match the user_password';
  if(!isset($_POST['user_confirm_password'])){ 
    throw new Exception($error, 400); 
  }

  // trim = removes whitespace from the beginning and the end of a string
  $_POST['user_confirm_password'] = trim($_POST['user_confirm_password']);
  if( $_POST['user_password'] != $_POST['user_confirm_password']){
    throw new Exception($error, 400); 
  }
}

