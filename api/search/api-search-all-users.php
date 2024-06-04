<section class="admin-view-all-users">

<!-- Creating the setup/layout of the search-output ------------------------------------------>
    <div class="section-header">
        <h2> Users </h2>

        <!-- The search-function: Creates (post) a value inside the form (action = "") -->
        <form class="search-data-function" method="post" action="">
            
            <!-- Text-field, with a given attribute-name (the input field MUST have a value to get submitted) -->
            <input type="text" name="searchUser" placeholder="🔍 Search by 'User ID'" required>

            <!-- The button MUST be inside the form, to tricker the function of the entire search (form) on the 'submit' -->
            <button type="submit">Search</button>
        </form>

    </div>

    <div class="view-all-users-header">
        <div> User Id </div>
        <div> Name </div>
        <div> Last Name </div>
        <div> Email </div>
        <div> Address </div>
        <div> Role </div>
        <div> Created at </div>
        <div> Updated at </div>
        <div> Deleted at </div>
        <div> Status </div>
    </div>

<?php

// Errorhandling... in case of potentiel errors occuring during database operation

    // Try to get all the users from the users-table in the database (and show the ones matching the given query-statement)
    // And bind the value in the search to 'match' with a potential value in the database (user_id)
    try{
        $db = _db();

        // Ternary-statement (short if-else): Checks if the variable exists, and how handle provided/non-provided data 
        // If the search contains data, search for the data – if not, leave it as an empty string
        $search_query = isset($_POST['searchUser']) ? $_POST['searchUser'] : '';

        // Show the specific user based on the searched user_id
        if ($search_query) {
            $q = $db->prepare(' SELECT * FROM users 
                                WHERE user_id LIKE :user_id
                                -- LIMIT 5
                            ');
            $q->bindValue(':user_id', "%$search_query%");

        // Show all the users as default (if no search is given)
        } else {
            $q = $db->prepare(' SELECT * FROM users ');
        }

        $q->execute();
        $users = $q->fetchAll();

    
    // If the connection didn't go through, show the occured error/exception during the operation
    }catch(Exception $e){
        try{
            if( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }
            http_response_code($e->getCode());
            echo json_encode(['info'=>$e->getMessage()]);
        } catch(Exception $ex){
            http_response_code(500);
            echo json_encode($ex); 
        }
    }


// Foreach matched found-user inside the 'users'-table 

    // If-else statement: Checks if the result has any matching rows... (more than 0)
    if (count($users) > 0) {   

        // If yes, display the matching results
        // ... fetch associative arrays with matching results - insert into the "table"
        foreach ($users as $user) { 
            echo "<div class='view-all-users'>";
            echo "<div class='user-output'>{$user['user_id']}</div>";
            echo "<div class='user-output'>{$user['user_name']}</div>";
            echo "<div class='user-output'>{$user['user_last_name']}</div>";
            echo "<div class='user-output'>{$user['user_email']}</div>";
            echo "<div class='user-output'>{$user['user_address']}</div>";
            echo "<div class='user-output'>{$user['user_role']}</div>";
            echo "<div class='user-output'>{$user['user_created_at']}</div>";
            echo "<div class='user-output'>{$user['user_updated_at']}</div>";
            echo "<div class='user-output'>{$user['user_deleted_at']}</div>";
            echo "<button onclick=\"toggle_blocked({$user['user_id']}, {$user['user_is_blocked']})\">";
            echo $user['user_is_blocked'] == 0 ? "Unblocked" : "Blocked";
            echo "</button>";
            echo "</div>";
        }

    // No matching results (count = 0), display following 'error'-message
    } else {
        echo "<p class='failed-matching-orders'>No matching users found.</p>"; 
    }

    ?>

</section>
