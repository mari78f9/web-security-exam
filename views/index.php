<?php 
require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';
?>

<section class="project-header">
    <h1> WebDev Exam 2023 </h1>
    <p>  Created by Viktoria Andonovska </p>
</section>

<main class="landingpage">  

    <section class="landingpage-redirect">
        <div class="signup-container">
            <h2> New user? </h2>
            <p> Join the team! </p>
            <a href="/views/signup.php">
                <button> SIGNUP</button>
            </a>
        </div>

        <div class="login-container">
            <h2> Hungry? </h2>
            <p> Welcome back! We've missed you! </p>
            <a href="/views/login.php">
                <button> LOGIN </button>
            </a>
        </div>

    </section> 
    <h1>File Upload</h1>
    <form action="../api/api-upload-files.php" method="post" enctype="multipart/form-data">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

    <h1>Search File</h1>
    <form action="/views/_display-file.php" method="get">
        <label for="file_id">File ID:</label>
        <input type="text" id="file_id" name="file_id">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <input type="submit" value="Search">
    </form>

</main>

<?php require_once __DIR__ . '/_footer.php'  ?>