<?php
// Database connection
// Include sensitive data
require_once 'assets/db/dbconnection.php';

// Start the session
session_start();

// Check if an admin session is started
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    // Admin session is active, perform admin-specific actions or redirect
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["logout"])) {
        // Perform logout and destroy session
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        // Perform admin-specific actions or redirect
        header("Location: admin/admindashboard.php");
        exit();
    }
} elseif (isset($_SESSION['faculty_id']) && !empty($_SESSION['faculty_id'])) {
    // Faculty session is active, perform faculty-specific actions or redirect
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["logout"])) {
        // Perform logout and destroy session
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        // Perform faculty-specific actions or redirect
        header("Location: faculty/facmyprofile.php");
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in your username and password as required.');</script>";
    } else {
        // Check in the admin table
        $adminQuery = "SELECT `admin_id`, `username`, `password` FROM `admin` WHERE `username` = ? AND `password` = ?";
        $adminStmt = $conn->prepare($adminQuery);
        $adminStmt->bind_param("ss", $username, $password);
        $adminStmt->execute();
        $adminResult = $adminStmt->get_result();

        // Check if admin credentials are correct
        if ($adminResult->num_rows > 0) {
            $_SESSION["admin_id"] = $adminResult->fetch_assoc()["admin_id"];
            header("Location: admin/admindashboard.php"); // Redirect to admin page
            exit();
        }

        // Check in the faculty table
        $facultyQuery = "SELECT `faculty_id`, `first_name`, `middle_name`, `last_name`, `email`, `phone_number`, `birth_date`, `gender`, `department_id`, `role_id`, `pincode`, `city`, `state`, `country`, `password` FROM `faculty` WHERE `email` = ? AND `password` = ?";
        $facultyStmt = $conn->prepare($facultyQuery);
        $facultyStmt->bind_param("ss", $username, $password);
        $facultyStmt->execute();
        $facultyResult = $facultyStmt->get_result();

        // Check if faculty credentials are correct
        if ($facultyResult->num_rows > 0) {
            $_SESSION["faculty_id"] = $facultyResult->fetch_assoc()["faculty_id"];
            header("Location: faculty/facmyprofile.php"); // Redirect to faculty page
            exit();
        }

        // If no matching records found, display an alert
        echo "<script>alert('Invalid username and password. Please try again.');</script>";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["login_attempt"])) {
    // Unauthorized access after login attempt
    unset($_SESSION["login_attempt"]); // Remove the login attempt flag

    // Check if any session is active, if yes, redirect to respective pages
    if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
        header("Location: admin/admindashboard.php");
        exit();
    } elseif (isset($_SESSION['faculty_id']) && !empty($_SESSION['faculty_id'])) {
        header("Location: faculty/facmyprofile.php");
        exit();
    }

    // Otherwise, display "Unauthorized access" message
    echo "<script>alert('Unauthorized access.');</script>";
}
?>

<!-- HTML Head -->
<?php include 'assets/include/head.php'; ?>
<!-- HTML Head -->

<!-- Add a Favicon -->
<link rel="shortcut icon" href="assets/img/nlcfavicon.ico" type="image/x-icon">

<!-- CSS link -->

<link rel="stylesheet" href="assets/css/login.css">

<!-- Page Title -->
<title>NLC LOGIN</title>

</head>

<body>

    <!-- MAIN BODY CONTAIN START -->

    <div class="container">
        <div class="banner">
            <img src="assets/img/logoheader.png" alt="Banner Image">
        </div>
        <div class="content">
            <div class="login-form">
                <form action="" method="post">
                    <legend>Login</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="username">Username:</label>
                            </td>
                            <td>
                                <input type="email" name="username" id="username" placeholder="Enter your email" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password:</label>
                            </td>
                            <td>
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            </td>
                        </tr>
                    </table>

                    <input type="submit" name="login" value="Login">

                    <div class="forgotpass">
                        <a href="forgotpass.php">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <footer>
                <p class="footer-text">&copy; <span id="currentYear"></span> Document Management System by
                    Kukil phukan. All rights reserved.</p>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let currentYear = new Date().getFullYear();
                        let currentYearSpan = document.querySelector("#currentYear");
                        currentYearSpan.innerHTML = currentYear;
                    });
                </script>
            </footer>
        </div>
    </div>

    <!-- MAIN BODY CONTAIN END -->

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>

<!-- END -->