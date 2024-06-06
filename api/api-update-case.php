<?php

require_once __DIR__.'/../_.php';

header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['case_id']) && isset($_POST['case_solved'])) {
//         $case_id = $_POST['case_id'];
//         $case_solved = (int)$_POST['case_solved'];

//         try {
//             $db = _db();
//             $q = $db->prepare('UPDATE cases SET case_solved = :case_solved, case_updated_at = :updated_at WHERE case_id = :case_id');
//             $q->bindParam(':case_solved', $case_solved, PDO::PARAM_INT);
//             $q->bindParam(':updated_at', time(), PDO::PARAM_INT);
//             $q->bindParam(':case_id', $case_id, PDO::PARAM_STR);
//             $q->execute();

//             if ($q->rowCount() > 0) {
//                 echo json_encode(['success' => true, 'message' => 'Case solved status updated.']);
//             } else {
//                 echo json_encode(['error' => 'Case not found or no change in status.']);
//             }
//         } catch (PDOException $e) {
//             echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
//         }
//     } else {
//         echo json_encode(['error' => 'Missing required fields.']);
//     }
// } else {
//     echo json_encode(['error' => 'Only POST requests are allowed.']);
// }

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that required fields are present
    if (isset($_POST['case_id']) && isset($_POST['case_solved'])) {
        // Extract data from POST request
        $case_id = $_POST['case_id'];
        $case_solved = $_POST['case_solved'];

        try {
            // Update the case in the database
            $db = _db();
            $q = $db->prepare('UPDATE cases SET case_solved = :solved WHERE case_id = :id');
            $q->bindParam(':solved', $case_solved, PDO::PARAM_BOOL);
            $q->bindParam(':id', $case_id);
            $q->execute();

            // Respond with success message
            http_response_code(200); // OK status code
            echo json_encode(array("message" => "Case solved status updated successfully."));
        } catch (PDOException $e) {
            // Respond with error message
            http_response_code(500); // Internal Server Error status code
            echo json_encode(array("error" => "Failed to update case solved status. " . $e->getMessage()));
        }
    } else {
        // Respond with error message if required fields are missing
        http_response_code(400); // Bad Request status code
        echo json_encode(array("error" => "Missing required fields."));
    }
} else {
    // Respond with error message if not a POST request
    http_response_code(405); // Method Not Allowed status code
    echo json_encode(array("error" => "Only POST requests are allowed."));
}

?>
