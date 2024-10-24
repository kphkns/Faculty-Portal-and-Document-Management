<?php
// Include sensitive data and establish database connection
require_once 'dbconnection.php';

// Start the session
session_start();

// Check if the document key is provided in the query string
if (isset($_GET['document_key'])) {
    $documentKey = $_GET['document_key'];

    // Check if the faculty_id is stored in the session
    if (isset($_SESSION['faculty_id'])) {
        $faculty_id = $_SESSION['faculty_id'];

        // Query the database to validate the document key and faculty access
        $query = "SELECT file_name, file_path FROM documents WHERE faculty_id = '$faculty_id' AND document_key = '$documentKey'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fileName = $row['file_name'];
            $filePath = '../../assets/document/' . $row['file_path'];

            $filePath = str_replace('C:\xampp\htdocs\docmanagement\assets\document', '../assets/document', $row['file_path']);


            // Serve the file
            $file = $filePath;

            // Get the file extension
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Set appropriate headers based on the file extension
            switch ($fileExtension) {
                case 'pdf':
                    header("Content-Type: application/pdf");
                    break;
                case 'jpg':
                case 'jpeg':
                    header("Content-Type: image/jpeg");
                    break;
                case 'png':
                    header("Content-Type: image/png");
                    break;
                    // Add more cases for other file formats if needed
                default:
                    header("Content-Type: application/octet-stream");
            }

            // Set other headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: inline; filename=" . $fileName);
            header("Content-Transfer-Encoding: binary");

            // Read the file and output it to the browser
            readfile($file);
            exit;
        } else {
            // Invalid document key or access
            echo '<script>alert("Invalid document key or access.");</script>';
            echo '<script>window.location.href = document.referrer;</script>';
        }
    } else {
        // Faculty ID not found in session
        echo '<script>alert("Faculty ID not found in session.");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
    }
} else {
    // Document key not provided
    echo '<script>alert("Document key not provided.");</script>';
    echo '<script>window.location.href = document.referrer;</script>';
}
