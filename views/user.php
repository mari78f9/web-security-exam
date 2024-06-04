<!-- This is the user page -->
<?php 

require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

?>

<section class="user-page">
  
  <h1 class="header-page"> User </h1>

  <?php require_once __DIR__.'/view_profile.php'  ?>

</section>


<?php require_once __DIR__.'/../api/search/api-search-own-orders.php'  ?>

<?php require_once __DIR__.'/_footer.php'  ?>

