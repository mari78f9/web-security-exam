<!-- This is the partner page -->
<?php 

require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

?>

<section class="user-page">
  
  <h1 class="header-page"> Partner </h1>

  <?php require_once __DIR__.'/view_profile.php'  ?>

</section>


<?php require_once __DIR__.'/../api/search/api-search-all-orders.php'  ?>

<?php require_once __DIR__.'/_footer.php'  ?>

