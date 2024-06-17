<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /views/error.php");
    exit();
}
?>

<div>

    <div class="dashboard-menu-links">
        <img src="/images/dashboard-dark.png" alt="Dashboard">
        <a href="/views/dashboard.php"> Dashboard </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/profile-dark.png" alt="Profile">
        <a href="/views/view-profile.php"> View profile </a>
    </div>

    <!-- Admin -->
    <?php if ($user['role_id_fk'] === 4): ?>
    <div class="dashboard-menu-links">
        <img src="/images/users-dark.png" alt="Users">
        <a href="/views/users.php"> View users </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File registry </a>
    </div>

    <!-- Detective -->
    <?php elseif ($user['role_id_fk'] === 1): ?>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File registry </a>
    </div>

    <!-- Lawyer -->
    <?php elseif ($user['role_id_fk'] === 2): ?>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>
    
    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File registry </a>
    </div>

    <!-- Citizen -->
    <?php elseif ($user['role_id_fk'] === 3): ?>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <?php endif; ?>
</div>