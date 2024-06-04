<!-- This is the admin page -->
<?php 

require_once __DIR__.'/../_.php'; 
require_once __DIR__.'/_header.php';

// If there's no user in the session, return to the login-page
if (! isset($_SESSION['user'])){
    header("Location: /login");
}

?>

<section class="admin-page">
    <h1 class="header-page"> Admin </h1>
</section>

<?php require_once __DIR__.'/../api/search/api-search-all-users.php'  ?>

<?php require_once __DIR__.'/../api/search/api-search-all-orders.php'  ?>

<?php require_once __DIR__.'/_footer.php' ?>  
