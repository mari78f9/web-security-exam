<?php 
require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];
?>

<main class="dashboard">

    <!-- Left side -->
    <section class="dashboard-menu">

        <!-- Top-Left -->
        <div class="dashboard-menu-top">
            
            <img src="/images/profile-dark.png" alt="user_profile"> <br>
            <span id="user_name"> <?= $user['user_name'] ?> </span> <span id="user_last_name"> <?= $user['user_last_name'] ?> </span> </span>
            <p id="user_role"> <?= $user['role_id_fk'] ?> </p>

        </div>
       
        <!-- Bottom-Left -->
        <div class="dashboard-menu-bottom">

            <div>

                <div class="dashboard-menu-links-active">
                    <img src="/images/dashboard-light.png" alt="Dashboard">
                    <a href="/views/dashboard.php"> Dashboard </a>
                </div>

                <div class="dashboard-menu-links">
                    <img src="/images/profile-dark.png" alt="Profile">
                    <a href="/views/view_profile.php"> View profile </a>
                </div>

                <div class="dashboard-menu-links">
                    <img src="/images/users-dark.png" alt="Users">
                    <a href="/views/users.php"> View users </a>
                </div>

                <div class="dashboard-menu-links">
                    <img src="/images/case-dark.png" alt="Case">
                    <a href="/views/create-case.php"> Create new case </a>
                </div>

                <div class="dashboard-menu-links">
                    <img src="/images/cases-dark.png" alt="Cases">
                    <a href="/views/cases.php"> View cases </a>
                </div>

                <div class="dashboard-menu-links">
                    <img src="/images/file-dark.png" alt="File">
                    <a href="/views/files.php"> File registry </a>
                </div>

            </div>

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">
        <span> Welcome back, <span id="user_name"> <?= $user['user_name'] ?> </span> </span>

        <div class="button-display">

            <button class="dashboard-button" id="dashboard-profile">
                <img src="/images/profile-light.png" alt="Profile"> <br>
                <h2> View Profile </h2>
            </button>

            <button class="dashboard-button" id="dashboard-users">
                <img src="/images/users-light.png" alt="Users"> <br>
                <h2> View Users </h2>
            </button>

            <button class="dashboard-button" id="dashboard-new-case">
                <img src="/images/case-light.png" alt="Case"> <br>
                <h2 href=""> Create new case </h2>
            </button>

            <button class="dashboard-button" id="dashboard-cases">
                <img src="/images/cases-light.png" alt="Cases"> <br>
                <h2> View Cases </h2>
            </button>

            <button class="dashboard-button" id="dashboard-file">
                <img src="/images/file-light.png" alt="File"> <br>
                <h2> File Registry </h2>
            </button>

        </div>

        <div class="logo">
            <img src="/images/logo.png" alt="Logo">
        </div>
    
    </section>

    
    
</main>



</body>
</html>