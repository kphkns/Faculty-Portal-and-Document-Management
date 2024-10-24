<!-- START -->
<?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page or any other desired page
    header('Location: ../../login.php');
    exit;
} else {
    // Retrieve the admin_id from the session
    $adminId = $_SESSION['admin_id'];

    // Prepare the SELECT query
    $sql = "SELECT * FROM `admin` WHERE admin_id = $adminId";

    // Continue with your code here
    // Execute the query and process the results
} ?>

<!-- HTML Head -->
<?php include '../include/head.php'; ?>
<link rel="shortcut icon" href="../img/nlcfavicon.ico" type="image/x-icon">
<!-- HTML Head -->

<!-- CSS link -->

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Ubuntu', sans-serif;
    }


    body {
        background: aliceblue;
    }

    .container {
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-image: url("../img/nlcoldimg.jpg");
        background-size: cover;
        background-position: center;
    }

    .banner {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: #333;
        padding: 10px 0;
        text-align: center;
    }

    .banner img {
        max-width: 100%;
        height: auto;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .profile {
        text-align: center;
        margin-bottom: 10px;
    }

    .profile img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card {
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 10px;
        text-align: center;
    }

    .card h1 {
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .card label {
        display: block;
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .card select,
    .card input[type="submit"] {
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: #f1f1f1;
        font-size: 16px;
        width: 100%;
        max-width: 300px;
        box-sizing: border-box;
    }

    .card input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        cursor: pointer;
    }

    .card input[type="submit"]:hover {
        background-color: #45a049;
    }

    .card button {
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .card button:hover {
        background-color: #555;
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #333;
        padding: 16px 0;
        text-align: center;
        color: #fff;
        font-size: 12px;
    }
</style>

<!-- Page Title -->
<title>Get Document</title>

</head>

<body>

    <div class="container">
        <div class="banner">
            <img src="../img/logoheader.png" alt="Banner Image">
        </div>
        <div class="content">

            <div class="profile">
                <?php
                // Retrieve the faculty_id from the URL query parameter
                $faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

                // Query to retrieve the document key and file name for the profile image
                $query = "SELECT document_key, file_name, file_path FROM documents WHERE faculty_id = ? AND category_id = 1"; // Replace 1 with the actual category_id for profile images

                // Prepare the statement
                $stmt = mysqli_prepare($conn, $query);

                // Bind the faculty_id parameter
                mysqli_stmt_bind_param($stmt, "i", $faculty_id);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Get the result
                $result = mysqli_stmt_get_result($stmt);

                // Check if a profile image is found
                if (mysqli_num_rows($result) > 0) {
                    // Display the profile image
                    $row = mysqli_fetch_assoc($result);
                    $documentKey = $row['document_key'];
                    $fileName = $row['file_name'];
                    $filePath = $row['file_path'];

                    // Check if the file is an image
                    if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf') {
                        // Display the default profile image
                        echo '<img src="../img/user.png" alt="user profile" onclick="return false;">';
                    } else {
                        // Display the actual profile image
                        $imagePath = "../db/view_image.php?document_key=" . $documentKey;
                        echo '<img src="' . $imagePath . '" alt="' . $fileName . '" onclick="return false;">';
                    }
                } else {
                    // Display the default profile image
                    echo '<img src="../img/user.png" alt="user profile" onclick="return false;">';
                }

                // Close the statement
                mysqli_stmt_close($stmt);
                ?>
            </div>
            <!-- <div class="profile">
                <img src="../img/user.png" alt="Profile Photo">
            </div> -->
            <div class="card">

                <h1>
                    <?php
                    // Retrieve the faculty_id from the URL query parameter
                    $faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

                    // Fetch the name for the faculty_id from the database
                    $query = "SELECT first_name, middle_name, last_name FROM faculty WHERE faculty_id = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "i", $faculty_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $firstName = $row['first_name'];
                        $middleName = $row['middle_name'];
                        $lastName = $row['last_name'];

                        // Combine the name parts
                        $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;

                        echo $fullName;
                    } else {
                        echo "Unknown Faculty";
                    }

                    mysqli_stmt_close($stmt);
                    ?>
                </h1>

                <!-- <h1>name</h1> -->

                <label for="doc">Choose Document:</label>

                <?php
                // Retrieve the faculty_id from the URL query parameter
                $faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

                // Add the faculty_id as a hidden input field
                echo "<input type='hidden' name='id' value='$faculty_id'>";
                ?>

                <form action="get_document.php?id=<?php echo urlencode($faculty_id); ?>" method="post" target="_blank">

                    <select name="document" required>

                        <option value="" disabled selected>Select Get Document</option>

                        <?php
                        // Retrieve category data from the database
                        $categorySql = "SELECT * FROM doccategories WHERE 1";
                        $categoryResult = mysqli_query($conn, $categorySql);

                        // Generate <option> tags for each category
                        while ($categoryData = mysqli_fetch_assoc($categoryResult)) {
                            $categoryId = $categoryData['category_id'];
                            $categoryName = $categoryData['name'];
                            echo "<option value='$categoryId'>$categoryName</option>";
                        }
                        ?>

                    </select>

                    <input type="submit" value="Get Document">

                </form>

                <!-- Added back button -->
                <button onclick="goBack()">Back</button>

                <script>
                    function goBack() {
                        window.location.href = "../../admin/adminfaculty.php";
                    }
                </script>

            </div>
        </div>

        <!-- Footer Here -->
        <div class="footer">
            <footer>
                <p class="footer-text">&copy; <span id="currentYear"></span> Document Management System by Basanta
                    Kakoti and Bishal Saikia. All rights reserved.</p>
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

</body>

</html>