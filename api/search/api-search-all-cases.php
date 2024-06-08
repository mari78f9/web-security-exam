<section class="admin-view-all-orders">

<!-- Creating the setup/layout of the search-output ------------------------------------------>
    <div class="section-header">
        <h2> Cases </h2>

        <!-- The search-function: Creates (post) a value inside the form (action = "") -->
        <form class="search-data-function" method="post" action="">

            <!-- Text-field, with a given attribute-name (the input field MUST have a value to get submitted) -->
            <input type="text" name="search" placeholder="🔍 Search by 'Case ID'" required>

            <!-- The button MUST be inside the form, to tricker the function of the entire search (form) on the 'submit' -->
            <button type="submit">Search</button> 
        </form>

    </div>

    <div class="view-all-orders-header">
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

// Errorhandling... in case of potentiel errors occuring during database operation

    // Try to get all the orders from the orders-table in the database (and show the ones matching the given query-statement)
    // And bind the value in the search to 'match' with a potential value in the database (order_id)
    try{
        $db = _db();

        // Ternary-statement (short if-else): Checks if the variable exists, and how handle provided/non-provided data 
        // If the search contains data, search for the data – if not, leave it as an empty string
        $search_query = isset($_POST['search']) ? $_POST['search'] : '';

        // Show an specific order, from the orders table, based on the searched order_id 
        if ($search_query) {
            $q = $db->prepare(' SELECT * FROM cases 
                                WHERE case_id LIKE :case_id
                                -- LIMIT 5
                            ');
            $q->bindValue(':case_id', "%$search_query%");

        // Show all the orders as default (if no search is given)
        } else {
            $q = $db->prepare(' SELECT * FROM cases');
        }
        
        $q->execute();
        $cases = $q->fetchAll();
    
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


// Foreach matched found-order inside the 'orders'-table 

    // If-else statement: Checks if the result has any matching rows... (more than 0)
    if (count($cases) > 0) {    

        // If yes, display the matching results
        // ... fetch associative arrays with matching results - insert into the "table"
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
        
    // No matching results (count = 0), display following 'error'-message
    } else {
        echo "<p class='failed-matching-cases'> No matching cases found. </p>";  
    }
?>

</section>

</body>
</html>
