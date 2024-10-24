<?php
// Set database credentials
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "docmanagement";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

error_reporting(0);

// echo "Connected successfully";
?>