<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set response content type as JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Extract case ID, case solved status, case tip, and case public status from POST data
    $caseId = $_POST['case_id'] ?? null;
    $caseSolved = $_POST['case_solved'] ?? null;
    $caseTip = $_POST['case_tip'] ?? null;
    $caseIsPublic = $_POST['case_is_public'] ?? null;
  
    // Check if the case ID is provided
    // Used preg_match to validate case_id to ensure it contains only alphanumeric characters.
    if ($caseId && preg_match('/^[a-zA-Z0-9]+$/', $caseId)) {
        try {

            // Connect to the database
            $db = _db();

            // Check if the case ID exists
            $q = $db->prepare('SELECT * FROM cases WHERE case_id = :case_id');
            $q->execute([':case_id' => $caseId]);
            $case = $q->fetch(PDO::FETCH_ASSOC);

            if (!$case) {
                // Output error message in JSON format if case ID does not exist
                http_response_code(400);
                echo json_encode(['error' => 'Invalid case ID']);
                exit();
            }

            // Update case solved status if provided
            if ($caseSolved !== null) {
                $q = $db->prepare('UPDATE cases SET case_solved = :case_solved, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_solved' => $caseSolved, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            // Update case tip if provided
            if ($caseTip !== null) {
                $q = $db->prepare('UPDATE cases SET case_tip = CONCAT(COALESCE(case_tip, \'\'), :case_tip), case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_tip' => "\n".$caseTip, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            // Update case public status if provided
            if ($caseIsPublic !== null) {
                $q = $db->prepare('UPDATE cases SET case_is_public = :case_is_public, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_is_public' => $caseIsPublic, ':updated_at' => time(), ':case_id' => $caseId]);
            }

           // Output success message in JSON format
           echo json_encode(['success' => true]);

        // PDOException handles exceptions specific to PDO operations, such as database connection errors, query execution errors, etc.
        } catch (PDOException $e) {

            // Output error message in JSON format if a PDO exception occurs
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {

            // Output error message in JSON format if a general exception occurs
            http_response_code(500);
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }
    } else {

        // Output error message in JSON format if case ID is invalid or not provided
        http_response_code(400);
        echo json_encode(['error' => 'Invalid case ID']);
    }
} else {

    // Output error message in JSON format if the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}

?>
