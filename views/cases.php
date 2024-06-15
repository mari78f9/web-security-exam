<?php

require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];

if (!isset($_SESSION['user'])){
    header("Location: error.php");
    exit();
}
?>

<main class="dashboard">

    <!-- Left side -->
    <section class="dashboard-menu">

        <!-- Top-Left -->
        <div class="dashboard-menu-top">
            
            <!-- Make sure to sanitize output with htmlspecialchars to prevent XSS attacks -->
            <img src="/images/profile-dark.png" alt="user_profile"> <br>
            <span id="user_name"> <?= htmlspecialchars($user['user_name']) ?> </span> <span id="user_last_name"> <?= htmlspecialchars($user['user_last_name']) ?> </span> </span>
            <p id="user_role"> <?= htmlspecialchars($user['role_name']) ?> </p>

        </div>
       
        <!-- Bottom-Left -->
        <div class="dashboard-menu-bottom">

        <?php require_once __DIR__ . '/../api/api-navigation.php'  ?>

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">
       
        <div id="newCase" class="new-case">
            <?php require_once __DIR__ . '/../views/create-case.php'  ?>
        </div>

        <?php if ($user['role_id_fk'] === 4): ?>
            <div class="create-case">
                <button onclick="createCrime()"> + </button>
            </div>
        <?php endif; ?>

        <div class="case-folder">
            <p> Cases </p>
        </div>

        <div class="case-folder-back">
            <p> . </p>
        </div>
        
        <?php require_once __DIR__ . '/../api/search/api-search-all-cases.php'  ?>
    
    </section>

    
    
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>