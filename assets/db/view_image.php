<?php
// Include sensitive data and establish database connection
require_once 'dbconnection.php';

// Check if the document key is provided in the query string
if (isset($_GET['document_key'])) {
    $documentKey = $_GET['document_key'];

    // Query the database to retrieve the file path for the given document key
    $query = "SELECT file_path FROM documents WHERE document_key = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $documentKey);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the document exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['file_path'];

        // Construct the full file path
        $fullFilePath = '../../assets/document/' . $filePath;

        // Check if the file exists
        if (file_exists($fullFilePath)) {
            // Get the file extension
            $fileExtension = pathinfo($fullFilePath, PATHINFO_EXTENSION);

            // Check if the file is an image
            if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
                // Set appropriate headers for image files
                header("Content-Type: image/jpeg");
                header("Content-Length: " . filesize($fullFilePath));

                // Read the image file and output it to the browser
                readfile($fullFilePath);
                exit;
            }
        }
    }
}

// If the document or file is not found, or it is not an image, display the default image
header("Content-Type: image/png");
$defaultImageFilePath = '../assets/img/user.png';
readfile($defaultImageFilePath);
?>
