<section class="admin-view-all-cases">

    <!-- Section header with a title and a search form -->
    <div class="section-header">
        <h2> Cases </h2>

        <!-- Form for searching cases by ID -->
        <form class="search-data-function" method="post" action="">

            <!-- Input field for entering the case ID to search -->
            <input type="text" name="search" placeholder="🔍 Search by 'Case ID'" required>

            <!-- Submit button for the search form -->
            <button type="submit">Search</button> 
        </form>
    </div>

    <!-- Header row for displaying the case information columns -->
    <div class="view-all-cases-header">
        <div> Case Id </div>
        <div> Description </div>
        <div> Suspect </div>
        <div> Type </div>
        <div> Location </div>
        <div> Tip </div>
        <div> Solved </div>
        <div> Created at </div>
        <div> Updated at </div>
        <div> Public </div>
    </div>

<?php

    // Error handling in case of potential errors during database operation
    try {

        // Connect to the database
        $db = _db();

        // Check if the search query exists, otherwise leave it as an empty string
        $search_query = isset($_POST['search']) ? $_POST['search'] : '';

        // If a search query is provided, search for cases with the matching case_id
        if ($search_query) {
            $q = $db->prepare(' SELECT * FROM cases 
                                WHERE case_id LIKE :case_id
                            ');
            $q->bindValue(':case_id', "%$search_query%");
        } else {

            // If no search query is provided, retrieve all cases
            $q = $db->prepare(' SELECT * FROM cases');
        }
        
        // Execute the query
        $q->execute();

        // Fetch all matching cases
        $cases = $q->fetchAll();
    
    // Handle exceptions during the database operation
    } catch (Exception $e) {
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

    // Check if there are any matching cases
    if (count($cases) > 0) {    

        // Loop through each case and display the information
        foreach ($cases as $row) {    
            echo "<div class='view-all-cases'>";
            echo "<div class='case-output'>{$row['case_id']}</div>";
            echo "<div class='case-output'>{$row['case_description']}</div>";
            echo "<div class='case-output'>{$row['case_suspect']}</div>";
            echo "<div class='case-output'>{$row['case_type']}</div>";
            echo "<div class='case-output'>{$row['case_location']}</div>";
            echo "<div class='case-output'>{$row['case_tip']}</div>";
            echo "<div class='case-output'>{$row['case_solved']}</div>";
            echo "<div class='case-output'>{$row['case_created_at']}</div>";
            echo "<div class='case-output'>{$row['case_updated_at']}</div>";
            echo "<div class='case-output'>{$row['case_is_public']}</div>";
            echo "</div>";
        }

    } else {

        // If no matching cases are found, display an error message
        echo "<p class='failed-matching-cases'> No matching cases found. </p>";  
    }
?>

</section>

</body>
</html>
