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
<link rel="stylesheet" href="../assets/css/adminfaculty.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN FACULTY</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<!-- <span>
    <a href=""><i class="fa-solid fa-house"></i></a>
    <a href="">Faculty</a>
</span> -->
<h1>Faculty</h1>
</div>

<!-- CONTAIN START -->

<div class="container">
    <!-- Add New Faculty -->

    <?php

    // Check if the form is submitted
    if (isset($_POST['submitdata'])) {
        // Retrieve the form data
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
        $password = $_POST['password'];

        // Perform backend validation
        $errors = array();

        // Validate first name
        if (empty($first_name)) {
            $errors[] = "First name is required";
        }

        // Validate last name
        if (empty($last_name)) {
            $errors[] = "Last name is required";
        }

        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        // Validate phone number
        if (empty($phone_number)) {
            $errors[] = "Phone number is required";
        } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
            $errors[] = "Invalid phone number format";
        }

        // Validate birth date
        if (empty($birth_date)) {
            $errors[] = "Birth date is required";
        }

        // Validate gender
        if (empty($gender)) {
            $errors[] = "Gender is required";
        }

        // Validate department
        if (empty($department)) {
            $errors[] = "Department is required";
        } else {
            // Check if the selected department exists in the department table
            $department_query = "SELECT `name` FROM `department` WHERE `department_id` = ?";
            $department_stmt = mysqli_prepare($conn, $department_query);
            mysqli_stmt_bind_param($department_stmt, "i", $department);
            mysqli_stmt_execute($department_stmt);
            $department_result = mysqli_stmt_get_result($department_stmt);

            if (mysqli_num_rows($department_result) === 0) {
                $errors[] = "Invalid department";
            } else {
                // Get the department name from the result
                $department_row = mysqli_fetch_assoc($department_result);
                $department_name = $department_row['name'];
            }
        }

        // Validate role
        if (empty($role)) {
            $errors[] = "Role is required";
        } else {
            // Check if the selected role exists in the designation table
            $role_query = "SELECT `role_id`, `name` FROM `designation` WHERE `role_id` = ?";
            $role_stmt = mysqli_prepare($conn, $role_query);
            mysqli_stmt_bind_param($role_stmt, "i", $role);
            mysqli_stmt_execute($role_stmt);
            $role_result = mysqli_stmt_get_result($role_stmt);

            if (mysqli_num_rows($role_result) === 0) {
                $errors[] = "Invalid role";
            } else {
                // Get the role name from the result
                $role_row = mysqli_fetch_assoc($role_result);
                $role_name = $role_row['name'];
            }
        }

        // Validate pincode
        if (empty($pincode)) {
            $errors[] = "Pincode is required";
        } elseif (!preg_match('/^[1-9][0-9]{5}$/', $pincode)) {
            $errors[] = "Invalid pincode format";
        }

        // Validate city
        if (empty($city)) {
            $errors[] = "City is required";
        }

        // Validate state
        if (empty($state)) {
            $errors[] = "State is required";
        }

        // Validate country
        if (empty($country)) {
            $errors[] = "Country is required";
        }

        // Validate password
        if (empty($password)) {
            $errors[] = "Password is required";
        }

        // If there are no validation errors, check for duplicate entries and proceed with database insertion
        if (empty($errors)) {
            // Check for duplicate email
            $email_query = "SELECT * FROM `faculty` WHERE `email` = ?";
            $email_stmt = mysqli_prepare($conn, $email_query);
            mysqli_stmt_bind_param($email_stmt, "s", $email);
            mysqli_stmt_execute($email_stmt);
            $email_result = mysqli_stmt_get_result($email_stmt);

            if (mysqli_num_rows($email_result) > 0) {
                $errors[] = "Email already exists";
            }

            // Check for duplicate phone number
            $phone_query = "SELECT * FROM `faculty` WHERE `phone_number` = ?";
            $phone_stmt = mysqli_prepare($conn, $phone_query);
            mysqli_stmt_bind_param($phone_stmt, "s", $phone_number);
            mysqli_stmt_execute($phone_stmt);
            $phone_result = mysqli_stmt_get_result($phone_stmt);

            if (mysqli_num_rows($phone_result) > 0) {
                $errors[] = "Phone number already exists";
            }

            // If there are no duplicate entries, proceed with database insertion
            if (empty($errors)) {
                // Prepare the query with placeholders
                $query = "INSERT INTO `faculty`(`first_name`, `middle_name`, `last_name`, `email`, `phone_number`, `birth_date`, `gender`, `department_id`, `role_id`, `pincode`, `city`, `state`, `country`, `password`)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = mysqli_prepare($conn, $query);

                // Bind the parameters to the statement
                mysqli_stmt_bind_param($stmt, "ssssssssssssss", $first_name, $middle_name, $last_name, $email, $phone_number, $birth_date, $gender, $department, $role, $pincode, $city, $state, $country, $password);

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    // Get the auto-generated faculty_id
                    $faculty_id = mysqli_insert_id($conn);
                    echo "<script>alert('Data inserted successfully. Faculty ID: $faculty_id');</script>";
                } else {
                    echo "<script>alert('Error inserting data: " . mysqli_error($conn) . "');</script>";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                // Display duplicate entry errors
                echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
            }
        } else {
            // Display validation errors
            echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
        }
    }
    ?>

    <div class="add-new-faculty">
        <button class="btn-addnew" onclick="openForm()">Add New</button>

        <div class="popup-form" id="popupForm">

            <form action="" method="post">

                <h1>ADD NEW FACULTY</h1>
                <div class="box">

                    <legend>Enter Your Name :</legend>

                    <label for="firstname">First name</label>
                    <input type="text" name="first_name" id="firstname" placeholder="Enter your first name" pattern="[A-Za-z]+" required>

                    <label for="middlename">Middle name</label>
                    <input type="text" name="middle_name" id="middlename" placeholder="Enter your middle name" pattern="[A-Za-z]+">

                    <label for="lastname">Last name</label>
                    <input type="text" name="last_name" id="lastname" placeholder="Enter your last name" pattern="[A-Za-z]+" required>

                    <legend>Enter your Details :</legend>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>

                    <label for="phonenumber">Phone number</label>
                    <input type="tel" name="phone_number" id="phonenumber" placeholder="Enter your phone number" pattern="[0-9]{10}" minlength="10" maxlength="10" required>

                    <label for="dob">Date of birth</label>
                    <input type="date" name="birth_date" id="dob" required>

                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>

                        <option disabled selected value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>

                    </select>

                    <legend>Enter your Faculty details :</legend>

                    <label for="department">Department</label>
                    <select name="department" id="department" required>

                        <option disabled selected value="">Select department</option>

                        <?php
                        // Check for connection errors
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        // Query the departments table
                        $sql = "SELECT * FROM department";
                        $result = mysqli_query($conn, $sql);

                        // Loop through the results and output the options
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['department_id'] . '">' . $row['name'] . '</option>';
                            }
                        }
                        ?>

                    </select>

                    <label for="Role">Role</label>
                    <select name="role" id="role" required>

                        <option disabled selected value="">Select Role</option>

                        <?php
                        // Check for connection errors
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        // Query the roles table
                        $sql = "SELECT `role_id`, `name` FROM `designation`";
                        $result = mysqli_query($conn, $sql);

                        // Loop through the results and output the options
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['role_id'] . '">' . $row['name'] . '</option>';
                            }
                        }
                        ?>

                    </select>

                    <legend>Enter Your Address</legend>

                    <label for="pincode">Pincode</label>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter Your Pincode" pattern="[1-9][0-9]{5}" required>

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter Your City" required>

                    <label for="state">State</label>
                    <input type="text" id="state" name="state" placeholder="Enter Your State" required>

                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" placeholder="Enter Your Country" required>

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

                    <legend>Create your password :</legend>

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <input type="password" placeholder="Confirm Password" id="confirm_password" required>

                    <div class="btn">
                        <input type="submit" class="button" name="submitdata" value="Submit">
                        <button type="button" onclick="closeForm()">Close</button>

                    </div>

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

        <script>
            function openForm() {
                document.getElementById("popupForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("popupForm").style.display = "none";
            }
        </script>

    </div>

    <!-- Faculty Table-->

    <div class="faculty-table">

        <?php
        // Retrieve data from the database with joins
        $query = "SELECT f.*, d.name AS department_name, r.name AS role_name
          FROM faculty f
          JOIN department d ON f.department_id = d.department_id
          JOIN designation r ON f.role_id = r.role_id";
        $result = mysqli_query($conn, $query);

        // Check if any data was retrieved
        if (mysqli_num_rows($result) > 0) {
            // Output the HTML table header
            echo '<table id="faculty-table">
        <thead>
            <tr>
                <th style="text-align: center;">Faculty Id</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Phone Number</th> 
                <th style="text-align: center;">DOB</th>
                <th style="text-align: center;">Gender</th> 
                <th style="text-align: center;">Department</th> 
                <th style="text-align: center;">Role</th>
                <th style="text-align: center;">Address</th>
                <th style="text-align: center;">Document</th> 
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';

            // Loop through the database results and output the table rows and cells
            while ($row = mysqli_fetch_assoc($result)) {
                $fullName = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                $address = $row['city'] . ', ' . $row['state'] . ', ' . $row['country'] . ' - ' . $row['pincode'];

                echo '<tr>
            <td>' . $row['faculty_id'] . '</td>
            <td>' . $fullName . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['phone_number'] . '</td>
            <td>' . $row['birth_date'] . '</td>
            <td>' . $row['gender'] . '</td>
            <td>' . $row['department_name'] . '</td>
            <td>' . $row['role_name'] . '</td>
            <td>' . $address . '</td>
            <td>
                <a href="../assets/db/doc_faculty.php?id=' . $row['faculty_id'] . '"><i class="fa-solid fa-eye"></i> view doc</a>
            </td>
            <td>
                <a href="../assets/db/edit_faculty.php?id=' . $row['faculty_id'] . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <a href="../assets/db/delete_faculty.php?id=' . $row['faculty_id'] . '" onclick="return confirm(\'Are you sure you want to delete this faculty?\')"><i class="fa-solid fa-trash"></i> Delete</a>
            </td>
        </tr>';
            }

            // Output the HTML table footer
            echo '</tbody></table>';
        } else {
            echo '<p>No data available.</p>';
        }

        ?>

        <!-- DataTable jQuery Script -->

        <script>
            $(document).ready(function() {
                // Initialize DataTable and set the column title for Faculty Id
                $('#faculty-table').DataTable({
                    columnDefs: [{
                        title: 'Faculty Id',
                        targets: 0
                    }]
                });

                // Add select box for filtering by Department
                var departmentFilter = $('<select>')
                    .appendTo('#faculty-table_wrapper .dataTables_filter')
                    .on('change', function() {
                        $('#faculty-table').DataTable().column(6).search($(this).val()).draw();
                    });

                departmentFilter.append('<option value="">Filter by Department</option>');

                // Get unique department values from the table
                var departments = $('#faculty-table').DataTable().column(6).data().unique();
                departments.sort();

                departments.each(function(value, index) {
                    departmentFilter.append('<option value="' + value + '">' + value + '</option>');
                });

                // Add select box for filtering by Role
                var roleFilter = $('<select>')
                    .appendTo('#faculty-table_wrapper .dataTables_filter')
                    .on('change', function() {
                        $('#faculty-table').DataTable().column(7).search($(this).val()).draw();
                    });

                roleFilter.append('<option value="">Filter by Role</option>');

                // Get unique role values from the table
                var roles = $('#faculty-table').DataTable().column(7).data().unique();
                roles.sort();

                roles.each(function(value, index) {
                    roleFilter.append('<option value="' + value + '">' + value + '</option>');
                });
            });
        </script>

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