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
<link rel="stylesheet" href="../assets/css/facultynavbar.css">

<!-- css main-body contain -->
<link rel="stylesheet" href="../assets/css/facmyprofile.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/facultyfooter.css">

<!-- Page Title -->
<title>Faculty Myprofile</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/facultynavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<h1>My profile</h1>
</div>
<div class="container">

    <div class="profile">
        <?php
        // Retrieve the faculty_id from the session or replace it with the actual value
        $faculty_id = $_SESSION['faculty_id'];

        // Query to retrieve the document key and file name for the profile image
        $query = "SELECT document_key, file_name, file_path FROM documents WHERE faculty_id = ? AND category_id = 1";

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
                echo '<img src="../assets/img/user.png" alt="user profile" onclick="return false;">';
            } else {
                // Display the actual profile image
                $imagePath = "../assets/db/view_image.php?document_key=" . $documentKey;
                echo '<img src="' . $imagePath . '" alt="' . $fileName . '" onclick="return false;">';
            }
        } else {
            // Display the default profile image
            echo '<img src="../assets/img/user.png" alt="user profile" onclick="return false;">';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
        ?>
    </div>

    <!-- <div class="profile">
        <img src="../assets/img/user.png" alt="user profile">
    </div> -->


    <?php
    // Stored the faculty_id in the session variable 'faculty_id'
    $facultyId = $_SESSION['faculty_id'];

    // Prepare the SELECT query
    $sql = "SELECT * FROM `faculty` WHERE faculty_id = $facultyId";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();

        // Retrieve the first name, middle name, and last name from the fetched row
        $firstName = $row['first_name'];
        $middleName = $row['middle_name'];
        $lastName = $row['last_name'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $birth_date = $row['birth_date'];
        $gender = $row['gender'];
        $departmentId = $row['department_id'];
        $roleId = $row['role_id'];
        $pincode = $row['pincode'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];

        // Retrieve the department name based on the department ID
        $departmentQuery = "SELECT `name` FROM `department` WHERE `department_id` = $departmentId";
        $departmentResult = $conn->query($departmentQuery);
        $departmentRow = $departmentResult->fetch_assoc();
        $department = $departmentRow['name'];

        // Retrieve the role name based on the role ID
        $roleQuery = "SELECT `name` FROM `designation` WHERE `role_id` = $roleId";
        $roleResult = $conn->query($roleQuery);
        $roleRow = $roleResult->fetch_assoc();
        $role = $roleRow['name'];

        // Display the data dynamically in the HTML
        echo '<div class="name">';
        echo '<h1>' . $firstName . ' ' . $middleName . ' ' . $lastName . '</h1>';
        echo '</div>';

    } else {
        echo '<div class="name">';
        echo '<h1>No faculty found with the provided ID</h1>';
        echo '</div>';
    }
    ?>

    <!-- <div class="name">
        <h1>Name Here</h1>
    </div> -->

    <div class="box">

        <div class="card">
            <legend>Basic details</legend>

            <label for="">Email</label>
            <p class="card-text">
                <?php
                if (!empty($email)) {
                    echo '<span>' . $email . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">Phone number</label>
            <p class="card-text">
                <?php
                if (!empty($phone_number)) {
                    echo '<span>' . $phone_number . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">Date of birth</label>
            <p class="card-text">
                <?php
                if (!empty($birth_date)) {
                    echo '<span>' . $birth_date . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">Gender</label>
            <p class="card-text">
                <?php
                if (!empty($gender)) {
                    echo '<span>' . $gender . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

        </div>

        <div class="card">
            <legend>Faculty details</legend>

            <label for="">Department</label>
            <p class="card-text">
                <?php
                if (!empty($department)) {
                    echo '<span>' . $department . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">Designation</label>
            <p class="card-text">
                <?php
                if (!empty($role)) {
                    echo '<span>' . $role . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

        </div>

        <div class="card">
            <legend>Address</legend>

            <label for="">Pincode</label>
            <p class="card-text">
                <?php
                if (!empty($pincode)) {
                    echo '<span>' . $pincode . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">City</label>
            <p class="card-text">
                <?php
                if (!empty($city)) {
                    echo '<span>' . $city . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">State</label>
            <p class="card-text">
                <?php
                if (!empty($state)) {
                    echo '<span>' . $state . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

            <label for="">Country</label>
            <p class="card-text">
                <?php
                if (!empty($country)) {
                    echo '<span>' . $country . '</span>';
                } else {
                    echo 'No record found';
                }
                ?>
            </p>

        </div>

    </div>

</div>


</div>

<!-- MAIN BODY CONTAIN END -->

<!-- Footer Here -->
<?php include '../assets/include/facultyfooter.php'; ?>
<!-- Footer Here -->

<?php
// Close the database connection
$conn->close();
?>

<!-- END -->