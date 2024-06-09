<div>

    <div class="dashboard-menu-links">
        <img src="/images/dashboard-light.png" alt="Dashboard">
        <a href="/views/dashboard.php"> Dashboard </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/profile-dark.png" alt="Profile">
        <a href="/views/view_profile.php"> View profile </a>
    </div>

    <!-- Admin -->
    <?php if ($user['role_id_fk'] === 4): ?>
    <div class="dashboard-menu-links">
        <img src="/images/users-dark.png" alt="Users">
        <a href="/views/users.php"> View users </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/users-dark.png" alt="Users">
        <a href="/views/users.php"> Search users </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> Search cases </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/case-dark.png" alt="Case">
        <a href="/views/create-case.php"> Create new case </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/add-dark.png" alt="File">
        <a href="/views/files.php"> Add tip </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/file-upload.php"> File upload </a>
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
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> Search cases </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> Add tip </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File upload </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File registry </a>
    </div>

    <!-- Lawyer -->
    <?php elseif ($user['role_id_fk'] === 2): ?>

    <div class="dashboard-menu-links">
        <img src="/images/file-dark.png" alt="File">
        <a href="/views/files.php"> File registry </a>
    </div>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <!-- Citizen -->
    <?php elseif ($user['role_id_fk'] === 3): ?>

    <div class="dashboard-menu-links">
        <img src="/images/cases-dark.png" alt="Cases">
        <a href="/views/cases.php"> View cases </a>
    </div>

    <?php endif; ?>
</div>