<?php 
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';  

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];

// require_once __DIR__ . '/../api/api-authorization.php';  

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

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

            <?php require_once __DIR__ . '/../api/api-navigation.php'  ?>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">
        <span> Welcome back, <span id="user_name"> <?= htmlspecialchars($user['user_name']) ?> </span> </span>

        <div class="button-display">

            <?php require_once __DIR__ . '/../api/api-authorization.php'  ?>

        </div>

        <div class="logo">
            <img src="/images/logo.png" alt="Logo">
        </div>
    
    </section>

    
    
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>