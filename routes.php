<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// Define routes
get('/', 'views/index.php');
get('/login', 'views/login.php');
get('/signup', 'views/signup.php');
get('/error', 'views/error.php');

get('/cases', 'views/cases.php');
get('/citizen', 'views/citizen.php');
get('/create-case', 'views/create-case.php');
get('/dashboard', 'views/dashboard.php');
get('/file-upload', 'views/file-upload.php');
get('/files', 'views/files.php');
get('/team', 'views/team.php');
get('/tip', 'views/tip.php');
get('/users', 'views/users.php');
get('/view-profile', 'views/view-profile.php');

// Define API routes
get('/api/api-authorization', 'api/api-authorization.php');
post('/api/api-delete-user', 'api/api-delete-user.php');
get('/api/api-display-files', 'api/api-display-files.php');
get('/api/api-get-cases', 'api/api-get-cases.php');
get('/api/api-get-files', 'api/api-get-files.php');
get('/api/api-get-users', 'api/api-get-users.php');
get('/api/api-login', 'api/api-login.php');
post('/api/api-make-case', 'api/api-make-case.php');
get('/api/api-navigation', 'api/api-navigation.php');

// Route with callback
get('/callback', function(){
  echo 'Callback executed';
});

get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');

// Handle the routing
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
route($path, 'views/404.php');