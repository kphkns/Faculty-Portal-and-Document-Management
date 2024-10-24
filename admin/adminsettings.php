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
<link rel="stylesheet" href="../assets/css/adminsettings.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN SETTINGS</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<!-- <span>
    <a href=""><i class="fa-solid fa-house"></i></a>
    <a href="">Settings</a>
</span> -->
<h1>Settings</h1>
</div>

<!-- CONTAIN START -->

<div class="container">

    <div class="account_pass">

        <form action="" method="POST">
            <legend>Account settings</legend>
            <table>
                <tr>
                    <td>
                        <label for="old-password">Old Password:</label>
                    </td>
                    <td>
                        <input type="password" name="old_password" id="old-password"
                            placeholder="Enter your current password" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="new-password">New Password:</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="confirm-password">Confirm Password:</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Confirm Password" id="confirm_password" required>
                    </td>
                </tr>
            </table>

            <button type="submit">Change Password</button>
        </form>

        <!-- script for password and confirm_password -->

        <script>
            var password = document.getElementById("password"),
                confirm_password = document.getElementById("confirm_password");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>

        <?php
      
        // Retrieve the admin_id from the session
        if (isset($_SESSION['admin_id'])) {
            $adminId = $_SESSION['admin_id'];

            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the submitted passwords
                $oldPassword = $_POST['old_password'];
                $newPassword = $_POST['password'];

                // Retrieve the current admin password from the database
                $sql = "SELECT password FROM `admin` WHERE admin_id = $adminId";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    // Check if any rows were returned
                    if (mysqli_num_rows($result) > 0) {
                        // Fetch the admin data
                        $adminData = mysqli_fetch_assoc($result);
                        $currentPassword = $adminData['password'];

                        // Compare the old password directly (without case sensitivity or whitespace trimming)
                        if ($oldPassword == $currentPassword) {
                            // Update the admin password in the database
                            $updateSql = "UPDATE `admin` SET password = '$newPassword' WHERE admin_id = $adminId";
                            $updateResult = mysqli_query($conn, $updateSql);

                            if ($updateResult) {
                                // Password changed successfully
                                echo '<script>alert("Password changed successfully.");</script>';
                            } else {
                                // Error updating the password
                                echo '<script>alert("Error updating password.");</script>';
                            }
                        } else {
                            // Old password doesn't match
                            echo '<script>alert("Old password is incorrect.");</script>';
                        }
                    } else {
                        // No admin found with the provided admin ID
                        echo '<script>alert("Admin not found.");</script>';
                    }
                } else {
                    // Error executing the query
                    echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
                }
            }
        }
        ?>


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