<section class="admin-view-all-users">

    <!-- Section header with a title and a search form -->
    <div class="section-header">
        <h2> Users </h2>

        <!-- Form for searching users by User ID -->
        <form class="search-data-function" method="post" action="">
            
            <!-- Input field for entering the user ID to search -->
            <input type="text" name="searchUser" placeholder="🔍 Search by 'User ID'" required>

            <!-- Submit button for the search form -->
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Header row for displaying the user information columns -->
    <div class="view-all-users-header">
        <div> User Id </div>
        <div> Name </div>
        <div> Last Name </div>
        <div> Email </div>
        <div> Role </div>
        <div> Created at </div>
        <div> Updated at </div>
        <div> Deleted at </div>
        <div> Status </div>
    </div>

<?php

     // Error handling in case of potential errors during database operation
    try {

        // Connect to the database
        $db = _db();

        // Check if the search query exists, otherwise leave it as an empty string
        $search_query = isset($_POST['searchUser']) ? $_POST['searchUser'] : '';

        // If a search query is provided, search for users with the matching user_id
        if ($search_query) {
            $q = $db->prepare(' SELECT * FROM users 
                                WHERE user_id LIKE :user_id
                            ');
            $q->bindValue(':user_id', "%$search_query%");
        } else {

            // If no search query is provided, retrieve all users
            $q = $db->prepare(' SELECT * FROM users ');
        }

        // Execute the query
        $q->execute();

        // Fetch all matching users
        $users = $q->fetchAll();

    // Handle exceptions during the database operation
    } catch(Exception $e) {
        try {

            // If the exception has no code or message, throw a new exception
            if ( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }

            // Set HTTP response code to the exception code and output the exception message as JSON
            http_response_code($e->getCode());
            echo json_encode(['info'=>$e->getMessage()]);
        } catch (Exception $ex) {

            // If another exception occurs, set HTTP response code to 500 and output the exception as JSON
            http_response_code(500);
            echo json_encode($ex); 
        }
    }

// Check if there are any matching users
if (count($users) > 0) {   

    // Loop through each user and display the information
    foreach ($users as $user) { 

        // Get the role name from the roles table
        $role_id = $user['role_id_fk'];
        $role_query = $db->prepare('SELECT role_name FROM roles WHERE role_id = :role_id');
        $role_query->bindValue(':role_id', $role_id);
        $role_query->execute();
        $role = $role_query->fetchColumn();

        // Display user information
        echo "<div class='view-all-users'>";
        echo "<div class='user-output'>{$user['user_id']}</div>";
        echo "<div class='user-output'>{$user['user_name']}</div>";
        echo "<div class='user-output'>{$user['user_last_name']}</div>";
        echo "<div class='user-output'>{$user['user_email']}</div>";
        echo "<div class='user-output user-role'>$role</div>";
        echo "<div class='user-output'>{$user['user_created_at']}</div>";
        echo "<div class='user-output'>{$user['user_updated_at']}</div>";
        echo "<div class='user-output'>{$user['user_deleted_at']}</div>";
        echo "<button onclick=\"toggle_blocked({$user['user_id']}, {$user['user_is_blocked']})\">";
        echo $user['user_is_blocked'] == 0 ? "Unblocked" : "Blocked";
        echo "</button>";
        echo "</div>";
    }

    } else {

        // If no matching users are found, display an error message
        echo "<p class='failed-matching-orders'>No matching users found.</p>"; 
    }

    ?>

</section>
