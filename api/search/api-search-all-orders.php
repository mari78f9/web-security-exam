<section class="admin-view-all-orders">

<!-- Creating the setup/layout of the search-output ------------------------------------------>
    <div class="section-header">
        <h2> Orders </h2>

        <!-- The search-function: Creates (post) a value inside the form (action = "") -->
        <form class="search-data-function" method="post" action="">

            <!-- Text-field, with a given attribute-name (the input field MUST have a value to get submitted) -->
            <input type="text" name="search" placeholder="🔍 Search by 'Order ID'" required>

            <!-- The button MUST be inside the form, to tricker the function of the entire search (form) on the 'submit' -->
            <button type="submit">Search</button> 
        </form>

    </div>

    <div class="view-all-orders-header">
        <div> Order Id </div>
        <div> Products </div>
        <div> Total Price </div>
        <div> Customer </div>
        <div> Created at </div>
        <div> Status </div>
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
            $q = $db->prepare(' SELECT * FROM orders 
                                WHERE order_id LIKE :order_id
                                -- LIMIT 5
                            ');
            $q->bindValue(':order_id', "%$search_query%");

        // Show all the orders as default (if no search is given)
        } else {
            $q = $db->prepare(' SELECT * FROM orders');
        }
        
        $q->execute();
        $orders = $q->fetchAll();
    
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
    if (count($orders) > 0) {    

        // If yes, display the matching results
        // ... fetch associative arrays with matching results - insert into the "table"
        foreach ($orders as $row) {    
            echo "<div class='view-all-orders'>";
            echo "<div class='order-output'>{$row['order_id']}</div>";
            echo "<div class='order-output'>{$row['order_product']}</div>";
            echo "<div class='order-output'>{$row['order_total_price']}</div>";
            echo "<div class='order-output'>{$row['order_user_fk']}</div>";
            echo "<div class='order-output'>{$row['order_created_at']}</div>";
            echo "<div class='order-output'>{$row['order_status']}</div>";
            echo "</div>";
        }
        
    // No matching results (count = 0), display following 'error'-message
    } else {
        echo "<p class='failed-matching-orders'> No matching orders found. </p>";  
    }
?>

</section>

</body>
</html>
