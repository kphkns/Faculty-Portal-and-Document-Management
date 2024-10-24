<?php
// Include sensitive data
require_once 'dbconnection.php';

// Check if the ID parameter is set and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Escape the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if the category_id is not 1
    if ($id != 1) {
        // Update the associated documents to set their category_id to NULL
        $updateQuery = "UPDATE documents SET category_id = NULL WHERE category_id = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "i", $id);

        // Delete the document category from the database using a prepared statement
        $deleteQuery = "DELETE FROM doccategories WHERE category_id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $id);

        // Start a transaction
        mysqli_begin_transaction($conn);

        try {
            // Update the documents
            mysqli_stmt_execute($updateStmt);

            // Delete the category
            mysqli_stmt_execute($deleteStmt);

            // Commit the transaction
            mysqli_commit($conn);

            // Display a success message and redirect to the same page
            echo "<script>alert('Document category marked as deleted.');window.location.href='../../admin/admindocument.php';</script>";
        } catch (Exception $e) {
            // Rollback the transaction
            mysqli_rollback($conn);

            // Display an error message
            echo "<script>alert('Error marking document category as deleted: " . $e->getMessage() . "');</script>";
        }

        // Close the statements
        mysqli_stmt_close($updateStmt);
        mysqli_stmt_close($deleteStmt);
    } else {
        // Display a message that category_id 1 cannot be deleted
        echo "<script>alert('Category ID 1 cannot be deleted.');window.location.href='../../admin/admindocument.php';</script>";
    }
} else {
    // Display an error message
    echo "<script>alert('Invalid or missing ID parameter.');window.location.href='../../admin/admindocument.php';</script>";
}

// Close the database connection
mysqli_close($conn);
?>
