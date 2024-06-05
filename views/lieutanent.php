<!-- This is the admin page -->
<?php 

require_once __DIR__.'/../_.php'; 
require_once __DIR__.'/_header.php';

// If there's no user in the session, return to the login-page
// if (! isset($_SESSION['user'])){
//     header("Location: /login");
// }

?>

<section class="admin-page">
    <h1 class="header-page"> Lieutanent </h1>

    <h1>File Upload</h1>
    <form action="../api/api-upload-files.php" method="post" enctype="multipart/form-data">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <label for="case_id">Case ID:</label>
        <input type="text" id="case_id" name="case_id">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

    <h1>Search Files by Case ID</h1>
    <form id="search-form">
        <label for="search_case_id">Case ID:</label>
        <input type="text" id="search_case_id" name="case_id">
        <input type="submit" value="Search">
    </form>

    <div id="files-display"></div>

</section>
<script>
    document.getElementById('search-form').addEventListener('submit', function(event) {
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
<?php require_once __DIR__.'/_footer.php' ?>  
