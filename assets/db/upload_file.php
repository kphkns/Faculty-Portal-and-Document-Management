<?php
// Define the maximum file size in bytes (e.g., 5MB)
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Function to generate a random string of desired length
function generateRandomString($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

// Check if the file is uploaded without errors
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Check if the file size exceeds the limit
    if ($_FILES['file']['size'] > $maxFileSize) {
        echo '<script>alert("File size exceeds the limit. Maximum file size 5MB ");</script>';
        echo '<script>window.location.href = "../../faculty/facdocument.php?error=file_size";</script>';
        exit;
    } else {
        // Include sensitive data
        require_once 'dbconnection.php';

        // Start the session (assuming you have already started the session elsewhere)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the faculty_id is stored in the session
        if (isset($_SESSION['faculty_id'])) {
            $faculty_id = $_SESSION['faculty_id'];

            // Check if the file is uploaded without errors
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];

                // Generate a unique file name by appending a timestamp and a random string
                $timestamp = time();
                $random_string = generateRandomString(5); // Function to generate a random string of desired length
                $unique_file_name = $timestamp . '_' . $random_string . '_' . $file_name;

                // Generate the document key
                $document_key = 'DOC-' . strtoupper(substr(str_replace('-', '', uniqid('', true)), 0, 8));

                // Move the uploaded file to the desired directory
                $destination = '../document/' . $unique_file_name;
                if (move_uploaded_file($file_tmp, $destination)) {
                    // Retrieve the selected category from the form
                    $category_id = $_POST['category'];

                    // Check if there are existing files in the same category for the faculty
                    $existingFilesQuery = "SELECT file_name, file_path, document_key FROM documents WHERE faculty_id = '$faculty_id' AND category_id = '$category_id'";
                    $existingFilesResult = mysqli_query($conn, $existingFilesQuery);
                    $existingFilesCount = mysqli_num_rows($existingFilesResult);

                    if ($existingFilesCount > 0) {
                        $row = mysqli_fetch_assoc($existingFilesResult);
                        $existingFileName = $row['file_name'];
                        $existingFilePath = $row['file_path'];
                        $existingDocumentKey = $row['document_key'];

                        // Delete the existing file
                        unlink('../document/' . $existingFileName);

                        if ($existingDocumentKey === '') {
                            // Update the file details in the "documents" table when the document was not previously uploaded
                            $query = "UPDATE documents SET file_name = '$unique_file_name', file_path = '$destination', document_key = '$document_key', status_id = 3 WHERE faculty_id = '$faculty_id' AND category_id = '$category_id'";
                        } else {
                            // Update the file details in the "documents" table when the document was previously uploaded
                            $query = "UPDATE documents SET file_name = '$unique_file_name', file_path = '$destination', status_id = 3 WHERE faculty_id = '$faculty_id' AND category_id = '$category_id'";
                        }
                    } else {
                        // Insert the file details into the "documents" table when it's a new document
                        $query = "INSERT INTO documents (file_name, file_path, category_id, faculty_id, document_key, status_id) VALUES ('$unique_file_name', '$destination', '$category_id', '$faculty_id', '$document_key', 3)";
                    }

                    // Perform the query to update or insert the file details
                    if (mysqli_query($conn, $query)) {
                        // Redirect to the same page with a success message as a query parameter
                        header("Location: ../../faculty/facdocument.php?success=1");
                        exit;
                    } else {
                        echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
                    }
                } else {
                    echo '<script>alert("Error moving uploaded file.");</script>';
                }
            } else {
                echo '<script>alert("File upload failed.");</script>';
            }
        } else {
            echo '<script>alert("Faculty ID not found in session.");</script>';
        }
    }
} else {
    echo '<script>alert("File upload failed.");</script>';
}
?>









































<!-- < ?php
// Define the maximum file size in bytes (e.g., 5MB)
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Function to generate a random string of desired length
function generateRandomString($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

// Check if the file is uploaded without errors
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Check if the file size exceeds the limit
    if ($_FILES['file']['size'] > $maxFileSize) {
        echo '<script>alert("File size exceeds the limit.");</script>';
        echo '<script>window.location.href = "../../faculty/facdocument.php?error=file_size";</script>';
        exit;
    } else {
        // Include sensitive data
        require_once 'dbconnection.php';

        // Start the session (assuming you have already started the session elsewhere)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the faculty_id is stored in the session
        if (isset($_SESSION['faculty_id'])) {
            $faculty_id = $_SESSION['faculty_id'];

            // Check if the file is uploaded without errors
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];

                // Generate a unique file name by appending a timestamp and a random string
                $timestamp = time();
                $random_string = generateRandomString(5); // Function to generate a random string of desired length
                $unique_file_name = $timestamp . '_' . $random_string . '_' . $file_name;

                // Generate the document key
                $document_key = 'DOC-' . strtoupper(substr(str_replace('-', '', uniqid('', true)), 0, 8));

                // Move the uploaded file to the desired directory
                $destination = '../document/' . $unique_file_name;
                if (move_uploaded_file($file_tmp, $destination)) {
                    // Retrieve the selected category from the form
                    $category_id = $_POST['category'];

                    // Check if there are existing files in the same category for the faculty
                    $existingFilesQuery = "SELECT file_name, file_path FROM documents WHERE faculty_id = '$faculty_id' AND category_id = '$category_id'";
                    $existingFilesResult = mysqli_query($conn, $existingFilesQuery);
                    $existingFilesCount = mysqli_num_rows($existingFilesResult);

                    if ($existingFilesCount > 0) {
                        $row = mysqli_fetch_assoc($existingFilesResult);
                        $existingFileName = $row['file_name'];
                        $existingFilePath = $row['file_path'];

                        // Delete the existing file
                        unlink('../document/' . $existingFileName);

                        // Update the file details in the "documents" table
                        $query = "UPDATE documents SET file_name = '$unique_file_name', file_path = '$destination', document_key = '$document_key', status_id = 3 WHERE faculty_id = '$faculty_id' AND category_id = '$category_id'";
                    } else {
                        // Insert the file details into the "documents" table
                        $query = "INSERT INTO documents (file_name, file_path, category_id, faculty_id, document_key, status_id) VALUES ('$unique_file_name', '$destination', '$category_id', '$faculty_id', '$document_key', 3)";
                    }

                    // Perform the query to update or insert the file details
                    if (mysqli_query($conn, $query)) {
                        // Redirect to the same page with a success message as a query parameter
                        header("Location: ../../faculty/facdocument.php?success=1");
                        exit;
                    } else {
                        echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
                    }
                } else {
                    echo '<script>alert("Error moving uploaded file.");</script>';
                }
            } else {
                echo '<script>alert("File upload failed.");</script>';
            }
        } else {
            echo '<script>alert("Faculty ID not found in session.");</script>';
        }
    }
} else {
    echo '<script>alert("File upload failed.");</script>';
}
?> -->