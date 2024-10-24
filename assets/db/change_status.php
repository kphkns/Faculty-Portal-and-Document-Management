<?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the document ID and new status ID from the POST request
    $documentId = $_POST['document_id'];
    $statusId = $_POST['status_id'];

    // Perform database update to change the status
    $updateSql = "UPDATE `documents` SET `status_id` = '$statusId' WHERE `doc_id` = '$documentId'";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // Retrieve the updated status name from the database
        $statusSql = "SELECT `name` FROM `status` WHERE `status_id` = '$statusId'";
        $statusResult = mysqli_query($conn, $statusSql);
        $statusRow = mysqli_fetch_assoc($statusResult);
        $statusName = $statusRow['name'];

        // Prepare the response data
        $response = [
            'success' => true,
            'statusName' => $statusName
        ];
    } else {
        // Prepare the error response
        $response = [
            'success' => false,
            'message' => 'Error updating status'
        ];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
