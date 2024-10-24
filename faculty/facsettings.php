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
<link rel="stylesheet" href="../assets/css/facsettings.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/facultyfooter.css">

<!-- Page Title -->
<title>Faculty Settings</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/facultynavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<h1>Settings</h1>
</div>

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
            <div class="button-center">
                <button type="submit" name="submitpass">Change Password</button>
            </div>
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
        if (isset($_POST['submitpass'])) {
            // Retrieve the faculty_id from the session
            $facultyId = $_SESSION['faculty_id'];

            // Retrieve the form input values
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['password'];

            // Verify the old password
            $sql = "SELECT password FROM faculty WHERE faculty_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $facultyId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $storedPassword = $row['password'];

                if ($oldPassword === $storedPassword) {
                    // Prepare the UPDATE query
                    $sql = "UPDATE faculty SET password = ? WHERE faculty_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "si", $newPassword, $facultyId);
                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        // Password updated successfully
                        echo '<script>alert("Password updated successfully.");</script>';
                    } else {
                        // Error updating password
                        echo '<script>alert("Error updating password.");</script>';
                    }
                } else {
                    // Old password does not match
                    echo '<script>alert("Old password is incorrect.");</script>';
                }
            } else {
                // Faculty not found
                echo '<script>alert("Faculty not found.");</script>';
            }

            mysqli_stmt_close($stmt);
        }
        ?>

    </div>

    <div class="profile_settings">

        <?php
        // Retrieve the faculty_id from the session
        $facultyId = $_SESSION['faculty_id'];

        // Retrieve the existing data from the database
        $sql = "SELECT * FROM faculty WHERE faculty_id = $facultyId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Assign the values to variables
        $firstName = $row['first_name'];
        $middleName = $row['middle_name'];
        $lastName = $row['last_name'];
        $email = $row['email'];
        $phoneNumber = $row['phone_number'];
        $birthDate = $row['birth_date'];
        $gender = $row['gender'];
        $pincode = $row['pincode'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];

        ?>

        <form action="" method="post">
            <legend>Profile settings</legend>

            <table>
                <tr>
                    <td>
                        <label for="firstname">First name</label>
                    </td>
                    <td>
                        <input type="text" name="first_name" id="firstname" placeholder="Enter your first name"
                            pattern="[A-Za-z]+" value="<?php echo $firstName; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="middlename">Middle name</label>
                    </td>
                    <td>
                        <input type="text" name="middle_name" id="middlename" placeholder="Enter your middle name"
                            pattern="[A-Za-z]+" value="<?php echo $middleName; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lastname">Last name</label>
                    </td>
                    <td>
                        <input type="text" name="last_name" id="lastname" placeholder="Enter your last name"
                            pattern="[A-Za-z]+" required value="<?php echo $lastName; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td>
                        <input type="email" name="email" id="email" placeholder="Enter your email"
                            value="<?php echo $email; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="phonenumber">Phone number</label>
                    </td>
                    <td>
                        <input type="tel" name="phone_number" id="phonenumber" placeholder="Enter your phone number"
                            pattern="[0-9]{10}" value="<?php echo $phoneNumber; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="dob">Date of birth</label>
                    </td>
                    <td>
                        <input type="date" name="birth_date" id="dob" value="<?php echo $birthDate; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="gender">Gender</label>
                    </td>
                    <td>
                        <select name="gender" id="gender" required>
                            <option value="" disabled>Select gender</option>
                            <option value="male" <?php if ($gender === 'male')
                                echo 'selected'; ?>>Male</option>
                            <option value="female" <?php if ($gender === 'female')
                                echo 'selected'; ?>>Female</option>
                            <option value="other" <?php if ($gender === 'other')
                                echo 'selected'; ?>>Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="pincode">Pincode</label>
                    </td>
                    <td>
                        <input type="text" id="pincode" name="pincode" placeholder="Enter Your Pincode"
                            pattern="[1-9][0-9]{5}" value="<?php echo $pincode; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="city">City</label>
                    </td>
                    <td>
                        <input type="text" id="city" name="city" placeholder="Enter Your City"
                            value="<?php echo $city; ?>" readonly required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="state">State</label>
                    </td>
                    <td>
                        <input type="text" id="state" name="state" placeholder="Enter Your State"
                            value="<?php echo $state; ?>" readonly required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="country">Country</label>
                    </td>
                    <td>
                        <input type="text" id="country" name="country" placeholder="Enter Your Country"
                            value="<?php echo $country; ?>" readonly required>
                    </td>
                </tr>
            </table>

            <!-- script getting the city, state, and country information using Postal Pincode -->

            <script>
                const pincode = document.getElementById("pincode");
                const city = document.getElementById("city");
                const state = document.getElementById("state");
                const country = document.getElementById("country");

                pincode.addEventListener("input", () => {
                    const code = pincode.value;
                    if (code.length === 6 && /^\d+$/.test(code)) {
                        fetch('../assets/js/postalpincode.json')
                            .then(response => response.json())
                            .then(data => {
                                const matchingData = data.find(obj => obj.pincode === code);
                                if (matchingData) {
                                    city.value = matchingData.Districtname;
                                    state.value = matchingData.statename;
                                    country.value = matchingData.country;
                                } else {
                                    city.value = "";
                                    state.value = "";
                                    country.value = "";
                                }
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

            <div class="button-center">
                <button type="submit" name="submitupdate">Update Details</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submitupdate'])) {
            // Retrieve the faculty_id from the session
            $facultyId = $_SESSION['faculty_id'];

            // Retrieve the form input values
            $firstName = $_POST['first_name'];
            $middleName = $_POST['middle_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phone_number'];
            $birthDate = $_POST['birth_date'];
            $gender = $_POST['gender'];
            $pincode = $_POST['pincode'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];

            // Prepare the UPDATE query
            $sql = "UPDATE faculty SET 
            first_name = ?,
            middle_name = ?,
            last_name = ?,
            email = ?,
            phone_number = ?,
            birth_date = ?,
            gender = ?,
            pincode = ?,
            city = ?,
            state = ?,
            country = ?
            WHERE faculty_id = ?";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $sql);

            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt, "sssssssssssi", $firstName, $middleName, $lastName, $email, $phoneNumber, $birthDate, $gender, $pincode, $city, $state, $country, $facultyId);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Details updated successfully
                echo '<script>alert("Details updated successfully.");</script>';
            } else {
                // Error updating details
                echo '<script>alert("Error updating details.");</script>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
        ?>

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