<?php 

if (!isset($_SESSION['user'])){
    header("Location: error.php");
    exit();
}

?>

<div class="display-new-case">
    <div class="create-new-case">

        <div class="cancel-case">
            <button onclick="hideNewCrime()"> X </button>
        </div>

        <h1> Create New Case </h1>

        <form" class="new-case-description" id="create-case-form" onsubmit="makeCase(); return false">
            <label for="case_description">Description:</label>
            <textarea class="case-description" id="case_description" name="case_description" placeholder="Write a description of the case" required></textarea>
            <label for="case_suspect">Suspect:</label>
            <input type="text" id="case_suspect" name="case_suspect" placeholder="Name a suspect" required>
            <label for="case_type">Type:</label>
            <input type="text" id="case_type" name="case_type" placeholder="Type of crime committed" required>
            <label for="case_location">Location:</label>
            <input type="text" id="case_location" name="case_location" placeholder="Location of the crime scene" required>
            <button type="submit"> Create Case </button>
        </form>

    </div>
    
</div>