<?php
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
}

// Retrieve the faculty_id from the URL query parameter
$faculty_id = $_GET['id'];

// Validate the faculty_id
if (!is_numeric($faculty_id)) {
    // Invalid faculty_id, handle the error
    echo "<p>Error: Invalid faculty ID.</p>";
    exit();
}

// Retrieve the existing data for the faculty
$fetchSql = "SELECT * FROM faculty WHERE faculty_id = $faculty_id";
$fetchResult = mysqli_query($conn, $fetchSql);
$facultyData = mysqli_fetch_assoc($fetchResult);

// Check if faculty data exists
if (!$facultyData) {
    // Faculty not found, handle the error
    echo "<p>Error: Faculty not found.</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    // Update the faculty data in the database
    $updateSql = "UPDATE faculty SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name', email = '$email', phone_number = '$phone_number', birth_date = '$birth_date', gender = '$gender', department_id = '$department', role_id = '$role', pincode = '$pincode', city = '$city', state = '$state', country = '$country' WHERE faculty_id = $faculty_id";
    $updateResult = mysqli_query($conn, $updateSql);

    // Check if the update was successful
    if ($updateResult) {
        // Display success message with alert box
        echo '<script>alert("Faculty data updated successfully.");</script>';
        // Redirect to dash.php after 2 seconds
        echo '<script>setTimeout(function(){ window.location.href = "../../admin/adminfaculty.php"; }, 2000);</script>';
    } else {
        // Display error message with alert box
        echo '<script>alert("Error updating faculty data: ' . mysqli_error($conn) . '");</script>';
    }
}

?>

<!-- HTML Head -->
<?php include '../include/head.php'; ?>
<!-- HTML Head -->

<!-- Add a Favicon -->
<link rel="shortcut icon" href="../img/nlcfavicon.ico" type="image/x-icon">

<!-- CSS link -->

<link rel="stylesheet" href="../css/facedit.css">

<!-- Page Title -->
<title>FACULTY REG</title>

</head>

<body>

    <!-- MAIN BODY CONTAIN START -->

    <div class="container">
        <div class="banner">
            <img src="../img/logoheader.png" alt="Banner Image">
        </div>
        <div class="content">
            <form action="" method="post">

                <h1>FACULTY UPDATE</h1>
                <div class="box">

                    <legend>Enter Your Name :</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="firstname">First name</label>
                            </td>
                            <td>
                                <input type="text" name="first_name" id="firstname" placeholder="Enter your first name" pattern="[A-Za-z]+" required value="<?php echo $facultyData['first_name']; ?>">
                            </td>
                            <td>
                                <label for="middlename">Middle name</label>
                            </td>
                            <td>
                                <input type="text" name="middle_name" id="middlename" placeholder="Enter your middle name" pattern="[A-Za-z]+" value="<?php echo $facultyData['middle_name']; ?>">
                            </td>
                            <td>
                                <label for="lastname">Last name</label>
                            </td>
                            <td>
                                <input type="text" name="last_name" id="lastname" placeholder="Enter your last name" pattern="[A-Za-z]+" required value="<?php echo $facultyData['last_name']; ?>">
                            </td>
                        </tr>
                    </table>

                    <legend>Enter your Details :</legend>

                    <table>
                        <tr>
                            <td>
                                <label for="email">Email</label>
                            </td>
                            <td>
                                <input type="email" name="email" id="email" placeholder="Enter your email" required value="<?php echo $facultyData['email']; ?>">
                            </td>
                            <td>
                                <label for="phonenumber">Phone number</label>
                            </td>
                            <td>
                                <input type="tel" name="phone_number" id="phonenumber" placeholder="Enter your phone number" pattern="[0-9]{10}" required value="<?php echo $facultyData['phone_number']; ?>">
                            </td>
                            <td>
                                <label for="dob">Date of birth</label>
                            </td>
                            <td>
                                <input type="date" name="birth_date" id="dob" value="<?php echo $facultyData['birth_date']; ?>" required>
                            </td>
                            <td>
                                <label for="gender">Gender</label>
                            </td>
                            <td>
                                <select name="gender" id="gender" required>
                                    <option disabled selected value="">Select gender</option>
                                    <option value="male" <?php if ($facultyData['gender'] === 'male') echo 'selected'; ?>>Male</option>
                                    <option value="female" <?php if ($facultyData['gender'] === 'female') echo 'selected'; ?>>Female</option>
                                    <option value="other" <?php if ($facultyData['gender'] === 'other') echo 'selected'; ?>>Other</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <legend>Enter your Faculty details :</legend>

                    <table>
                        <tr>
                            <td>
                                <label for="department">Department</label>
                            </td>
                            <td>
                                <select name="department" id="department" required>

                                    <option disabled selected value="">Select department</option>

                                    <?php
                                    // Check for connection errors
                                    if (!$conn) {
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    // Query the departments table
                                    $sql = "SELECT `department_id`, `name`, `estd` FROM `department`";
                                    $result = mysqli_query($conn, $sql);

                                    // Loop through the results and output the options
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($row['department_id'] === $facultyData['department_id']) ? 'selected' : '';
                                            echo '<option value="' . $row['department_id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </td>
                            <td>
                                <label for="Role">Role</label>
                            </td>
                            <td>
                                <select name="role" id="role" required>

                                    <option disabled selected value="">Select Role</option>

                                    <?php
                                    // Check for connection errors
                                    if (!$conn) {
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    // Query the designation table
                                    $sql = "SELECT `role_id`, `name` FROM `designation`";
                                    $result = mysqli_query($conn, $sql);

                                    // Loop through the results and output the options
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($row['role_id'] === $facultyData['role_id']) ? 'selected' : '';
                                            echo '<option value="' . $row['role_id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </td>
                        </tr>
                    </table>

                    <legend>Enter Your Address</legend>

                    <table>
                        <tr>
                            <td>
                                <label for="pincode">Pincode</label>
                            </td>
                            <td>
                                <input type="text" id="pincode" name="pincode" placeholder="Enter Your Pincode" pattern="[1-9][0-9]{5}" required value="<?php echo $facultyData['pincode']; ?>">
                            </td>
                            <td>
                                <label for="city">City</label>
                            </td>
                            <td>
                                <input type="text" id="city" name="city" placeholder="Enter Your City" required value="<?php echo $facultyData['city']; ?>">
                            </td>
                            <td>
                                <label for="state">State</label>
                            </td>
                            <td>
                                <input type="text" id="state" name="state" placeholder="Enter Your State" required value="<?php echo $facultyData['state']; ?>">
                            </td>
                            <td>
                                <label for="country">Country</label>
                            </td>
                            <td>
                                <input type="text" id="country" name="country" placeholder="Enter Your Country" required value="<?php echo $facultyData['country']; ?>">
                            </td>
                        </tr>
                    </table>

                    <!-- script getting the city, state, and country information using Postal Pincode API -->

                    <script>
                        const pincode = document.getElementById("pincode");
                        const city = document.getElementById("city");
                        const state = document.getElementById("state");
                        const country = document.getElementById("country");

                        pincode.addEventListener("input", () => {
                            const code = pincode.value;
                            if (code.length === 6 && /^\d+$/.test(code)) {
                                fetch(`https://api.postalpincode.in/pincode/${code}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const postoffice = data[0].PostOffice[0];
                                        city.value = postoffice.District;
                                        state.value = postoffice.State;
                                        country.value = postoffice.Country;
                                    })
                                    .catch(error => {
                                        console.error(error);
                                        city.value = "";
                                        state.value = "";
                                        country.value = "";
                                    });
                            } else {
                                city.value = "";
                                state.value = "";
                                country.value = "";
                            }
                        });
                    </script>

                    <div class="btn">
                        <input type="submit" class="button" value="Update">
                    </div>

                    <div class="login">
                        <span>Details updated ?
                            <a href="../../admin/adminfaculty.php">Back</a>
                        </span>
                    </div>
                </div>

            </form>

            <!-- First complete currect email address -->

            <script>
                const emailInput = document.getElementById("email");
                const otherInputs = document.querySelectorAll(".box input:not(#email), .box select");

                function checkEmailValidity() {
                    const email = emailInput.value.trim();
                    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    return isValid;
                }

                function enableInputs() {
                    const isEmailValid = checkEmailValidity();

                    otherInputs.forEach((input) => {
                        input.disabled = !isEmailValid;
                    });
                }

                emailInput.addEventListener("input", enableInputs);
            </script>

        </div>

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

    <!-- MAIN BODY CONTAIN END -->

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>

<!-- END -->