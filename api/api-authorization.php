<?php

// Citizen Access
if ($_SESSION['user']['role_id_fk'] == 4) {
    echo '<script>
            document.getElementById("view_profile").style.display = "block";
            document.getElementById("create_case").style.display = "none";
          </script>';
    header("Location: /views/dashboard.php"); // Redirect to an unauthorized access page if the user is not an admin
    exit();
}





