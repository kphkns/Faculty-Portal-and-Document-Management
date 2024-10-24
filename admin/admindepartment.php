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
<link rel="stylesheet" href="../assets/css/admindepartment.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN DEPARTMENT</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->

<!-- <span>
    <a href=""><i class="fa-solid fa-house"></i></a>
    <a href="">Department</a>
</span> -->
<h1>Department</h1>
</div>

<!-- CONTAIN START -->

<div class="container">

    <!-- Add New Department -->

    <div class="add-new-department">

        <button class="btn-addnew" onclick="addDepartment()">Add New</button>

        <div class="popup-form" id="popupForm">

            <div class="add-box">

                <form action="" method="post">

                    <legend>Add New Department</legend>
                    <label for="department">Department</label>
                    <input type="text" name="department" id="department" placeholder="Department name" required>
                    <label for="estd">Establishment date</label>
                    <input type="date" name="estd" id="estd" required>

                    <button type="submit" name="add_department">Add Department</button>
                    <button type="button" onclick="closeDepartmentForm()">Close</button>

                </form>

            </div>

            <script>
                function addDepartment() {
                    document.getElementById("popupForm").style.display = "block";
                }

                function closeDepartmentForm() {
                    document.getElementById("popupForm").style.display = "none";
                }
            </script>

            <?php
            // Check if the form has been submitted
            if (isset($_POST['add_department'])) {

                // Retrieve the form data
                $name = $_POST['department'];
                $estd = $_POST['estd'];

                // Check if the department name already exists in the database
                $query = "SELECT * FROM department WHERE name = '$name'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo '<script>alert("Department name already exists.");</script>';
                } else {
                    // Insert the data into the database
                    $query = "INSERT INTO department (name, estd) VALUES ('$name', '$estd')";
                    $result = mysqli_query($conn, $query);

                    // Check if the data was inserted successfully
                    if ($result) {
                        echo '<script>alert("Department added successfully.");</script>';
                    } else {
                        echo '<script>alert("Failed to add department.");</script>';
                    }
                }
            }
            ?>

        </div>



    </div>

    <div class="department-table">

        <?php
        // Retrieve data from the database
        $query = "SELECT * FROM department";
        $result = mysqli_query($conn, $query);

        // Check if any data was retrieved
        if (mysqli_num_rows($result) > 0) {
            // Output the HTML table header
            echo '<table id="department-table">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Name</th>
                    <th>Estd</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';

            // Loop through the database results and output the table rows and cells
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                <td>' . $row['department_id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['estd'] . '</td>

                <td align="center"><a href="../assets/db/edit_department.php?id=' . $row['department_id'] . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a></td>

                <td align="center"><a href="../assets/db/delete_department.php?id=' . $row['department_id'] . '" onclick="return confirm(\'Are you sure you want to delete this department?\')"><i class="fa-solid fa-trash"></i> Delete</a></td>

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
            $('#department-table').DataTable({
                columns: [{
                    title: 'Department ID'
                },
                    null,
                    null,
                    null,
                    null
                ]
            });

            $('#department-table').DataTable({
                columnDefs: [{
                    title: 'Department ID',
                    targets: 0
                }]
            });

            var table = $('#department-table').DataTable();

            table.columns('.sum').every(function () {
                var sum = this
                    .data()
                    .reduce(function (a, b) {
                        return a + b;
                    });

                $(this.footer()).html('Sum: ' + sum);
            });

            var table = $('#department-table').DataTable();
            var column = table.column(0);

            $(column.footer()).html(
                column.data().reduce(function (a, b) {
                    return a + b;
                })
            );
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