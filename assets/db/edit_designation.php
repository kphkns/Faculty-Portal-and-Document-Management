<?php
// include the database connection file
include_once('dbconnection.php');

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

// check if the form was submitted
if (isset($_POST['submit'])) {
    // get the form data
    $role_id = $_POST['role_id'];
    $name = $_POST['name'];

    // prepare and execute the SQL query to update the record
    $stmt = $conn->prepare("UPDATE designation SET name=? WHERE role_id=?");
    $stmt->bind_param("si", $name, $role_id);
    $stmt->execute();

    // redirect the user to the designations page
    header('Location: ../../admin/admindesignation.php');
    exit();
}

// get the designation ID from the URL parameter
$role_id = $_GET['id'];

// prepare and execute the SQL query to retrieve the designation record
$stmt = $conn->prepare("SELECT * FROM designation WHERE role_id=?");
$stmt->bind_param("i", $role_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/nlcfavicon.ico" type="image/x-icon">

    <title>Edit Designation details</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Ubuntu', sans-serif;
        }

        body {
            background: #f2f2f2;
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

        .edit-designation {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f7f7f7;
            background-image: linear-gradient(to bottom, #f7f7f7, #e7e7e7);
            background-repeat: repeat-x;
            background-position: center;
        }

        .edit-designation form {
            margin-bottom: 10px;
        }

        .edit-designation form legend {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.5rem;
            text-align: center;
        }

        .edit-designation table {
            width: 100%;
        }

        .edit-designation table td {
            padding: 5px;
        }

        .edit-designation label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        .edit-designation input[type="text"] {
            width: 200px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .edit-designation button {
            margin-right: 10px;
            padding: 8px 20px;
            border: none;
            border-radius: 3px;
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .edit-designation button:hover {
            background-color: #45a049;
        }

        .edit-designation button.cancel {
            background-color: #666666;
        }

        .edit-designation button.cancel:hover {
            background-color: #808080;
        }

        .button-center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
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

</head>

<body>
    <div class="container">
        <div class="banner">
            <img src="../img/logoheader.png" alt="Banner Image">
        </div>

        <div class="edit-designation">
            <!-- HTML form to edit the designation -->
            <form method="post">
                <legend>Edit the designation details</legend>
                <table>
                    <tr>
                        <input type="hidden" name="role_id" value="<?php echo $row['role_id']; ?>">
                        <td>
                            <label for="designation_id">Designation ID:</label>
                        </td>
                        <td>
                            <input type="text" id="designation_id" name="designation_id"
                                value="<?php echo $row['role_id']; ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="name">Name:</label>
                        </td>
                        <td>
                            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                        </td>
                    </tr>
                </table>

                <div class="button-center">
                    <button type="submit" name="submit">Update</button>
                    <button type="button" class="cancel"
                        onclick="location.href='../../admin/admindesignation.php';">Cancel</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <footer>
                <p class="footer-text">&copy; <span id="currentYear"></span> Document Management System by Basanta
                    Kakoti and Bishal Saikia. All rights reserved.</p>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
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