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
<link rel="stylesheet" href="../assets/css/admindesignation.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN DESIGNATION</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<!-- <span>
    <a href=""><i class="fa-solid fa-house"></i></a>
    <a href="">Designation</a>
</span> -->
<h1>Designation</h1>
</div>

<!-- CONTAIN START -->

<div class="container">
    <!-- Add New Designation -->

    <div class="add-new-designation">

        <button class="btn-addnew" onclick="addDesignation()">Add New</button>

        <div class="popup-form" id="popupForm">

            <div class="add-box">

                <form action="" method="post">

                    <legend>Add New Designation</legend>
                    <label for="designation">Designation</label>
                    <input type="text" name="designation" id="designation" placeholder="Designation name" required>

                    <button type="submit" name="add_designation">Add Designation</button>
                    <button type="button" onclick="closeDesignationForm()">Close</button>

                </form>

            </div>

        </div>

        <script>
            function addDesignation() {
                document.getElementById("popupForm").style.display = "block";
            }

            function closeDesignationForm() {
                document.getElementById("popupForm").style.display = "none";
            }
        </script>

        <?php
        // Check if the form has been submitted
        if (isset($_POST['add_designation'])) {

            // Retrieve the form data
            $name = $_POST['designation'];

            // Check if the designation already exists in the database
            $query = "SELECT * FROM designation WHERE name = '$name'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("Designation already exists.");</script>';
            } else {
                // Insert the data into the database
                $query = "INSERT INTO designation (name) VALUES ('$name')";
                $result = mysqli_query($conn, $query);

                // Check if the data was inserted successfully
                if ($result) {
                    echo '<script>alert("Designation added successfully.");</script>';
                } else {
                    echo '<script>alert("Failed to add designation.");</script>';
                }
            }
        }
        ?>

    </div>

    <div class="designation-table">


        <?php
        // Retrieve data from the database
        $query = "SELECT * FROM designation";
        $result = mysqli_query($conn, $query);

        // Check if any data was retrieved
        if (mysqli_num_rows($result) > 0) {
            // Output the HTML table header
            echo '<table id="designation-table">
            <thead>
                <tr>
                    <th>Designation ID</th>
                    <th>Name</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';

            // Loop through the database results and output the table rows and cells
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                <td>' . $row['role_id'] . '</td>
                <td>' . $row['name'] . '</td>

                <td align="center"><a href="../assets/db/edit_designation.php?id=' . $row['role_id'] . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a></td>


                <td align="center"><a href="../assets/db/delete_designation.php?id=' . $row['role_id'] . '" onclick="return confirm(\'Are you sure you want to delete this designation?\')"><i class="fa-solid fa-trash"></i> Delete</a></td>

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
            $('#designation-table').DataTable({
                columns: [{
                        title: 'Designation ID'
                    },
                    null,
                    null,
                    null
                ]
            });

            $('#designation-table').DataTable({
                columnDefs: [{
                    title: 'Designation ID',
                    targets: 0
                }]
            });

            var table = $('#designation-table').DataTable();

            table.columns('.sum').every(function() {
                var sum = this
                    .data()
                    .reduce(function(a, b) {
                        return a + b;
                    });

                $(this.footer()).html('Sum: ' + sum);
            });

            var table = $('#designation-table').DataTable();
            var column = table.column(0);

            $(column.footer()).html(
                column.data().reduce(function(a, b) {
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