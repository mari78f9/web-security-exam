<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../_.php';

// Set response content type as JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Extract case ID, case solved status, case tip, and case public status from POST data
    $caseId = $_POST['case_id'] ?? null;
    $caseId = $_POST['case_id'] ?? null;
    $caseSolved = $_POST['case_solved'] ?? null;
    $caseTip = $_POST['case_tip'] ?? null;
    $caseIsPublic = $_POST['case_is_public'] ?? null;

    // Check if the case ID is provided
    if ($caseId) {
        try {

            // Connect to the database
            $db = _db();

            // Update case solved status if provided
            if ($caseSolved !== null) {
                $q = $db->prepare('UPDATE cases SET case_solved = :case_solved, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_solved' => $caseSolved, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            // Update case tip if provided
            if ($caseTip !== null) {
                $q = $db->prepare('UPDATE cases SET case_tip = :case_tip, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_tip' => $caseTip, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            // Update case public status if provided
            if ($caseIsPublic !== null) {
                $q = $db->prepare('UPDATE cases SET case_is_public = :case_is_public, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_is_public' => $caseIsPublic, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            // Output success message in JSON format
            echo json_encode(['success' => true]);
        } catch (Exception $e) {

            // Output error message in JSON format if an exception occurs during database operation
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {

        // Output error message in JSON format if case ID is invalid or not provided
        echo json_encode(['error' => 'Invalid case ID']);
    }
}

?>
