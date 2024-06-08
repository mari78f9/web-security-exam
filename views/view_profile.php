<?php

require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];

if (!isset($_SESSION['user'])){
    header("Location: login");
}
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

                <div class="dashboard-menu-links">
                    <img src="/images/dashboard-light.png" alt="Dashboard">
                    <a href="/views/dashboard.php"> Dashboard </a>
                </div>

                <div class="dashboard-menu-links-active">
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

        <section class="view-profile">
        <h2> View Profile </h2>

        <div class="view-profile-form">
                <form class="view-profile-form-input" onsubmit="validate(updateUser); return false">

                    <label class="profile-form-label" for="user_id"> ID </label> 
                        <div class="profile-form-input"><p id="user_id"> <?= $user['user_id'] ?> </p></div>
                        
                    <label class="profile-form-label" for="user_name">
                    Name <br> Your name must be min <?= USER_NAME_MIN?> and max <?= USER_NAME_MAX?> </label> 
                        <input id="user_name" class="profile-form-input" type="text" name="user_name" data-validate="str" data-min="<?= USER_NAME_MIN?>" data-max="<?= USER_NAME_MAX?>" value="<?= $user['user_name'] ?>">

                    <label class="profile-form-label" for="user_last_name"> Lastname <br> Your name must be min <?= USER_LAST_NAME_MIN?> and max <?= USER_LAST_NAME_MAX?> </label> 
                        <input id="user_last_name" class="profile-form-input" type="text" name="user_last_name" data-validate="str" data-min="<?= USER_LAST_NAME_MIN?>" data-max="<?= USER_LAST_NAME_MAX?>" value="<?= $user['user_last_name'] ?>">

                    <label class="profile-form-label" for="user_email"> Email </label> 
                        <input id="user_email" class="profile-form-input" type="email" name="user_email" data-validate="email" value="<?= $user['user_email'] ?>">

                    <button id="edit-profile" class="edit-profile"> Edit profile </button>
                
                </form>

            </div>
            
            <div>
                <button id="delete-profile" class="delete-profile" onclick="deleteUser()"> Delete profile </button>
            </div>
        </section>

        
    </section>

    
    
</main>






