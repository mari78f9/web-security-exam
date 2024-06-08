<?php

// Connects to the database
require_once __DIR__.'/database.php';

// Enable error display
ini_set('display_errors', 1);

// Start the session
session_start();

// ##############################
// Constants for user name validation
define('USER_NAME_MIN', 2);
define('USER_NAME_MAX', 20);

/**
 * Validate the user name.
 * 
 * This function checks if the user name is set, trims it, and validates its length.
 * 
 * throws Exception if the user name is not valid.
 */
function _validate_user_name(){
  $error = 'user_name min '.USER_NAME_MIN.' max '.USER_NAME_MAX;

  if(!isset($_POST['user_name'])){ 
    throw new Exception($error, 400); 
  }

  $_POST['user_name'] = trim($_POST['user_name']);

  if( strlen($_POST['user_name']) < USER_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_name']) > USER_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
// Constants for user last name validation
define('USER_LAST_NAME_MIN', 2);
define('USER_LAST_NAME_MAX', 20);

/**
 * Validate the user last name.
 * 
 * This function checks if the user last name is set, trims it, and validates its length.
 * 
 * throws Exception if the user last name is not valid.
 */
function _validate_user_last_name(){
  $error = 'user_last_name min '.USER_LAST_NAME_MIN.' max '.USER_LAST_NAME_MAX;

  if(!isset($_POST['user_last_name'])){ 
    throw new Exception($error, 400); 
  }

  $_POST['user_last_name'] = trim($_POST['user_last_name']);

  if( strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
/**
 * Validate the user email.
 * 
 * This function checks if the user email is set, trims it, and validates its format.
 * 
 * throws Exception if the user email is not valid.
 */
function _validate_user_email(){
  $error = 'user_email invalid';

  if(!isset($_POST['user_email'])){ 
    throw new Exception($error, 400); 
  }

  $_POST['user_email'] = trim($_POST['user_email']); 

  if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
    throw new Exception($error, 400); 
  }
}

// ##############################
// Constants for user password validation
define('USER_PASSWORD_MIN', 6);
define('USER_PASSWORD_MAX', 50);

/**
 * Validate the user password.
 * 
 * This function checks if the user password is set, trims it, and validates its length.
 * 
 * throws Exception if the user password is not valid.
 */
function _validate_user_password(){

  $error = 'user_password min '.USER_PASSWORD_MIN.' max '.USER_PASSWORD_MAX;

  if(!isset($_POST['user_password'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_password'] = trim($_POST['user_password']);

  if( strlen($_POST['user_password']) < USER_PASSWORD_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_password']) > USER_PASSWORD_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
/**
 * Validate the user confirm password.
 * 
 * This function checks if the user confirm password is set, trims it, and ensures it matches the user password.
 * 
 * throws Exception if the user confirm password does not match the user password.
 */
function _validate_user_confirm_password(){
  $error = 'user_confirm_password must match the user_password';
  if(!isset($_POST['user_confirm_password'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_confirm_password'] = trim($_POST['user_confirm_password']);
  if( $_POST['user_password'] != $_POST['user_confirm_password']){
    throw new Exception($error, 400); 
  }
}

// ##############################
/**
 * Output text safely.
 * 
 * This function echoes the given text after converting special characters to HTML entities.
 * 
 * param string $text The text to be output.
 */
function out($text){
  echo htmlspecialchars($text);
}

