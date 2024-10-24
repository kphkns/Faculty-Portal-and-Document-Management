<!-- START -->

<?php
// Database connection
// Include sensitive data
require_once '../assets/db/dbconnection.php';
?>

<!-- HTML Head -->
<?php include '../assets/include/head.php'; ?>
<!-- HTML Head -->

<!-- CSS link -->

<!-- css sidenavbar -->
<link rel="stylesheet" href="../assets/css/adminnavbar.css">

<!-- css main-body contain -->
<link rel="stylesheet" href="../assets/css/admindashboard.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN DASHBOARD</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<?php

// Stored the admin_id in the session variable 'admin_id'
$adminId = $_SESSION['admin_id'];

// Prepare the SELECT query
$sql = "SELECT * FROM `admin` WHERE admin_id = $adminId";


// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();

    // Retrieve the first name, middle name, and last name from the fetched row
    $username = $row['username'];

    // Display the data dynamically in the HTML
    echo '<span>Welcome Back ' . $username . '</span>';
} else {
    echo '<span>No admin found with the provided ID</span>';
}

?>
<!-- <span>Welcome Back</span> -->
<h1>Dashboard</h1>
</div>

<!-- CONTAIN START -->

<div class="box-wrapper">
    <h1 class="box-text"><i class="fa-solid fa-chart-pie"></i> Analysis</h1>
    <div class="card-wrapper">
        <div class="card">
            <i class="fa-solid fa-user"></i>
            <h2>Admin</h2>

            <?php
            $dash_category_query = "SELECT * FROM admin";
            $dash_category_query_run = mysqli_query($conn, $dash_category_query);

            if ($category_total = mysqli_num_rows($dash_category_query_run)) {
                echo "<p>" . $category_total . "</p>";
            } else {
                echo "<p>No Data</p>";
            }
            ?>

        </div>

        <div class="card">
            <i class="fa-solid fa-users"></i>
            <h2>Faculty</h2>

            <?php
            $dash_category_query = "SELECT * FROM faculty";
            $dash_category_query_run = mysqli_query($conn, $dash_category_query);

            if ($category_total = mysqli_num_rows($dash_category_query_run)) {
                echo "<p>" . $category_total . "</p>";
            } else {
                echo "<p>No Data</p>";
            }
            ?>

        </div>

        <div class="card">
            <i class="fa-solid fa-id-badge"></i>
            <h2>Department</h2>

            <?php
            $dash_category_query = "SELECT * FROM department";
            $dash_category_query_run = mysqli_query($conn, $dash_category_query);

            if ($category_total = mysqli_num_rows($dash_category_query_run)) {
                echo "<p>" . $category_total . "</p>";
            } else {
                echo "<p>No Data</p>";
            }
            ?>

        </div>

        <div class="card">
            <i class="fa-solid fa-pen-nib"></i>
            <h2>Designation</h2>

            <?php
            $dash_category_query = "SELECT * FROM designation";
            $dash_category_query_run = mysqli_query($conn, $dash_category_query);

            if ($category_total = mysqli_num_rows($dash_category_query_run)) {
                echo "<p>" . $category_total . "</p>";
            } else {
                echo "<p>No Data</p>";
            }
            ?>

        </div>
    </div>
</div>


<!-- MAIN BODY CONTAIN END -->

<!-- Footer Here -->
<?php include '../assets/include/adminfooter.php'; ?>
<!-- Footer Here -->

<?php
// Close the database connection
$conn->close();
?>

<!-- END -->