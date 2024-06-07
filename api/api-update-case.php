<?php

require_once __DIR__.'/../_.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caseId = $_POST['case_id'] ?? null;
    $caseSolved = $_POST['case_solved'] ?? null;
    $caseTip = $_POST['case_tip'] ?? null;
    $caseIsPublic = $_POST['case_is_public'] ?? null;

    if ($caseId) {
        try {
            $db = _db();
            if ($caseSolved !== null) {
                $q = $db->prepare('UPDATE cases SET case_solved = :case_solved, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_solved' => $caseSolved, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            if ($caseTip !== null) {
                $q = $db->prepare('UPDATE cases SET case_tip = :case_tip, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_tip' => $caseTip, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            if ($caseIsPublic !== null) {
                $q = $db->prepare('UPDATE cases SET case_is_public = :case_is_public, case_updated_at = :updated_at WHERE case_id = :case_id');
                $q->execute([':case_is_public' => $caseIsPublic, ':updated_at' => time(), ':case_id' => $caseId]);
            }

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid case ID']);
    }
}

// // Check if it's a POST request
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Ensure that required fields are present
//     if (isset($_POST['case_id']) && isset($_POST['case_solved']) || isset($_POST['case_tip'])) {
//         // Extract data from POST request
//         $case_id = $_POST['case_id'];
//         $case_solved = $_POST['case_solved'] ?? null;
//         $case_tip = $_POST['case_tip'] ?? null;

//         try {
//             // Update the case in the database
//             $db = _db();
//             $sql = 'UPDATE cases SET case_updated_at = :updated_at';
//             if ($case_solved !== null) {
//                 $sql .= ', case_solved = :solved';
//             }
//             if ($case_tip !== null) {
//                 $sql .= ', case_tip = :tip';
//             }
//             $sql .= ' WHERE case_id = :id';

//             $q = $db->prepare($sql);
//             $updated_at = time();
//             $q->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);
//             if ($case_solved !== null) {
//                 $q->bindParam(':solved', $case_solved, PDO::PARAM_BOOL);
//             }
//             if ($case_tip !== null) {
//                 $q->bindParam(':tip', $case_tip, PDO::PARAM_STR);
//             }
//             $q->bindParam(':id', $case_id, PDO::PARAM_STR);
//             $q->execute();

//             // Respond with success message
//             http_response_code(200); // OK status code
//             echo json_encode(array("message" => "Case updated successfully."));
//         } catch (PDOException $e) {
//             // Respond with error message
//             http_response_code(500); // Internal Server Error status code
//             echo json_encode(array("error" => "Failed to update case. " . $e->getMessage()));
//         }
//     } else {
//         // Respond with error message if required fields are missing
//         http_response_code(400); // Bad Request status code
//         echo json_encode(array("error" => "Missing required fields."));
//     }
// } else {
//     // Respond with error message if not a POST request
//     http_response_code(405); // Method Not Allowed status code
//     echo json_encode(array("error" => "Only POST requests are allowed."));
// }

?>
