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

<!-- http://localhost:8888/views/file-upload.php -->

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

        <?php require_once __DIR__ . '/_navigation.php'  ?>

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">

        <div id="fileUpload" class="file-upload-function">
            <?php require_once __DIR__ . '/../views/file-upload.php'  ?>
        </div>

        <?php if (in_array($user['role_id_fk'], [1, 4])): ?>
        <button class="upload-file" onclick="uploadFile()">
            <img src="/images/upload-file-light.png" alt="Users">
            <p> Upload file </p> 
        </button>
        <?php endif; ?>
        
        <h2> File Registry </h2>

        <form class="search-file-function" id="search-files">
            <input type="text" id="search_case_id" name="case_id" placeholder="🔍 Search by 'Case ID'">
            <button type="submit"> Search </button>
        </form>

        <div id="files-display">

            <?php require_once __DIR__ . '/../api/api-display-files.php'  ?>
       
        </div>

        <script>
            // Prevent form submission and handle search
            document.getElementById('search-files').addEventListener('submit', function(event) {
                event.preventDefault();

                var caseId = document.getElementById('search_case_id').value;

                fetch('../api/api-display-files.php?case_id=' + caseId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('files-display').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching files:', error);
                    document.getElementById('files-display').textContent = 'Error fetching files.';
                });
            });
        </script>
        
    </section>
    
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>