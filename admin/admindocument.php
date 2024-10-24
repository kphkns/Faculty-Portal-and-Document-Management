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
<link rel="stylesheet" href="../assets/css/admindocument.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/adminfooter.css">

<!-- Page Title -->
<title>ADMIN DOCUMENT</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/adminnavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<!-- <span>
    <a href=""><i class="fa-solid fa-house"></i></a>
    <a href="">Document</a>
</span> -->
<h1>Document categories</h1>
</div>

<!-- CONTAIN START -->

<div class="container">
    <!-- Add New Document categories -->

    <div class="add-new-documentcategories">

        <button class="btn-addnew" onclick="addDocumentcategories()">Add New</button>

        <div class="popup-form" id="popupForm">

            <div class="add-box">

                <form action="" method="post">

                    <legend>Add New Document Categories</legend>
                    <label for="document">Document</label>
                    <input type="text" name="document" id="document" placeholder="Document name" required>

                    <button type="submit" name="add_document">Add Document</button>
                    <button type="button" onclick="closeDocumentcategoriesForm()">Close</button>

                </form>

            </div>

        </div>

        <script>
            function addDocumentcategories() {
                document.getElementById("popupForm").style.display = "block";
            }

            function closeDocumentcategoriesForm() {
                document.getElementById("popupForm").style.display = "none";
            }
        </script>

        <?php
        // Check if the form has been submitted
        if (isset($_POST['add_document'])) {

            // Retrieve the form data
            $name = $_POST['document'];

            // Check if the document categories already exists in the database
            $query = "SELECT * FROM doccategories WHERE name = '$name'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("Document categories already exists.");</script>';
            } else {
                // Insert the data into the database
                $query = "INSERT INTO doccategories (name) VALUES ('$name')";
                $result = mysqli_query($conn, $query);

                // Check if the data was inserted successfully
                if ($result) {
                    echo '<script>alert("Document categories added successfully.");</script>';
                } else {
                    echo '<script>alert("Failed to add document categories.");</script>';
                }
            }
        }
        ?>

    </div>

    <div class="documentcategories-table">

        <?php

        // Retrieve data from the database
        $query = "SELECT * FROM doccategories";
        $result = mysqli_query($conn, $query);

        // Check if any data was retrieved
        if (mysqli_num_rows($result) > 0) {
            // Output the HTML table header
            echo '<table id="documentcategories-table">
            <thead>
                <tr>
                    <th>Document ID</th>
                    <th>Name</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';

            // Loop through the database results and output the table rows and cells
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                <td>' . $row['category_id'] . '</td>
                <td>' . $row['name'] . '</td>

                <td align="center"><a href="../assets/db/edit_doccategories.php?id=' . $row['category_id'] . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a></td>


                <td align="center"><a href="../assets/db/delete_doccategories.php?id=' . $row['category_id'] . '" onclick="return confirm(\'Are you sure you want to delete this document categories?\')"><i class="fa-solid fa-trash"></i> Delete</a></td>

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
            $('#documentcategories-table').DataTable({
                columns: [{
                        title: 'Document ID'
                    },
                    null,
                    null,
                    null
                ]
            });

            $('#documentcategories-table').DataTable({
                columnDefs: [{
                    title: 'Document ID',
                    targets: 0
                }]
            });

            var table = $('#documentcategories-table').DataTable();

            table.columns('.sum').every(function() {
                var sum = this
                    .data()
                    .reduce(function(a, b) {
                        return a + b;
                    });

                $(this.footer()).html('Sum: ' + sum);
            });

            var table = $('#documentcategories-table').DataTable();
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