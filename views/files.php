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

        <?php require_once __DIR__ . '/../api/api-navigation.php'  ?>

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">

        <h2>Search Files by Case ID</h2>
        <form id="search-files">
            <label for="search_case_id">Case ID:</label>
            <input type="text" id="search_case_id" name="case_id">
            <input type="submit" value="Search">
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