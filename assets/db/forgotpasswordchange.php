<?php
// Include sensitive data
require_once 'dbconnection.php';

// Turn off error reporting
error_reporting(0);
ini_set('display_errors', 0);

// Retrieve form data
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];
$birthDate = $_POST['birth_date'];
$newPassword = $_POST['password'];
$captchaInput = $_POST['captcha'];
$captchaAnswer = $_POST['captcha-answer'];

// Check if any required field is empty
if (empty($email) || empty($phoneNumber) || empty($birthDate) || empty($newPassword) || empty($captchaInput) || empty($captchaAnswer)) {
    echo "<script>alert('Please fill in all the required fields.'); window.location.href = '../../forgotpass.php';</script>";
    exit;
}

// Validate the captcha
if ($captchaInput != $captchaAnswer) {
    echo "<script>alert('Invalid captcha. Please try again.'); window.location.href = '../../forgotpass.php';</script>";
    exit;
}

// Perform database validation and password change
// Assuming you have a database connection established

// Validate user's credentials
$query = "SELECT * FROM faculty WHERE email = '$email' AND phone_number = '$phoneNumber' AND birth_date = '$birthDate'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    // Credentials are valid, proceed with password change
    // Update the password field
    $updateQuery = "UPDATE faculty SET password = '$newPassword' WHERE email = '$email'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Password updated successfully
        echo "<script>alert('Password updated successfully!'); window.location.href = '../../login.php';</script>";
        exit;
    } else {
        // Error occurred while updating the password
        echo "<script>alert('An error occurred while updating the password. Please try again.'); window.location.href = '../../forgotpass.php';</script>";
    }
} else {
    // Invalid credentials
    $checkExistQuery = "SELECT * FROM faculty WHERE email = '$email' OR phone_number = '$phoneNumber'";
    $checkExistResult = mysqli_query($conn, $checkExistQuery);

    if (mysqli_num_rows($checkExistResult) > 0) {
        // Either email or phone number exists, but the combination is incorrect
        echo "<script>alert('Invalid credentials. Please check your email, phone number, and birth date.'); window.location.href = '../../forgotpass.php';</script>";
    } else {
        // Email or phone number does not exist
        echo "<script>alert('Email or phone number does not exist. Please enter a valid email and phone number.'); window.location.href = '../../forgotpass.php';</script>";
    }
    exit;
}

// Close the database connection
$conn->close();
?>
