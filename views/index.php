<?php 
require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';
?>

<!-- <section class="project-header">
    <h1> Secret Undercover Crime Knights  </h1>
</section> -->

<main class="landingpage">  

    <section class="index-header">
        <div class="index-icon">
            <img src="/images/lock.png" alt="Lock">
        </div>
        <h1> Welcome to the SUCK Database </h1>
        <h2> Choose your user-condition </h2>

    </section>

    <section class="landingpage-redirect">

        <div class="redirect-containers">
            <a href="/views/signup.php">
                <button> Citizen </button>
            </a>

            <a href="/views/login.php">
                <button> Team </button>
            </a>

        </div>


    </section> 

</main>

<?php require_once __DIR__ . '/_footer.php'  ?>