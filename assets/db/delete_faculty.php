<?php
// Include sensitive data
require_once 'dbconnection.php';

// Check if the ID parameter is set
if (isset($_GET['id'])) {
    // Escape the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if there are any associated records in the "documents" table
    $checkQuery = "SELECT COUNT(*) FROM documents WHERE faculty_id = $id";
    $result = mysqli_query($conn, $checkQuery);
    $count = mysqli_fetch_array($result)[0];

    if ($count > 0) {
        // Delete associated records in the "documents" table
        $deleteQuery = "DELETE FROM documents WHERE faculty_id = $id";
        mysqli_query($conn, $deleteQuery);
    }

    // Delete the Faculty from the database
    $deleteQuery = "DELETE FROM faculty WHERE faculty_id = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        // Display a success message and redirect to the same page
        echo "<script>alert('Faculty deleted successfully.');window.location.href='../../admin/adminfaculty.php';</script>";
    } else {
        // Display an error message
        echo "<script>alert('Error deleting faculty: " . mysqli_error($conn) . "');</script>";
    }
} else {
    // Display an error message
    echo "<script>alert('ID parameter not set.');</script>";
}

// Close the database connection
mysqli_close($conn);
?>
