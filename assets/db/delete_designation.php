<?php
// Include sensitive data
require_once 'dbconnection.php';

// Check if the ID parameter is set
if (isset($_GET['id'])) {
    // Escape the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the designation from the database
    $query = "DELETE FROM designation WHERE role_id = $id";
    if (mysqli_query($conn, $query)) {
        // Display a success message and redirect to the same page
        echo "<script>alert('Designation deleted successfully.');window.location.href='../../admin/admindesignation.php';</script>";
    } else {
        // Display an error message
        echo "<script>alert('Error deleting designation: " . mysqli_error($conn) . "');</script>";
    }
} else {
    // Display an error message
    echo "<script>alert('ID parameter not set.');</script>";
}

// Close the database connection
mysqli_close($conn);
?>
