<?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" class=\"action-button\" onclick=\"printDocument('$documentPath');\">Print</a>
                    <a href=\"/docmanagement/assets/db/doc_faculty.php?id=$faculty_id\" class=\"action-button\">Back</a>
                </div>";

            // Add a form to change the status
            echo "<form onsubmit=\"changeStatus(event, $documentId); return false;\" style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id' class=\"custom-select\" required>
                        <option disabled selected value=''>Select a Status</option>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit' class=\"action-button\">Update Status</button>
                </form>";
        }
    } else {
        // echo "No documents available for the selected category and faculty.";
        echo "<script>
            alert('No documents available for the selected category and faculty.');
            window.location.href = 'doc_faculty.php?id=$faculty_id';
          </script>";
        exit();
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    function updateStatus(documentId, newStatusName) {
        var statusElement = document.getElementById('status_' + documentId);
        if (statusElement) {
            statusElement.textContent = newStatusName;
        }
    }

    function changeStatus(event, documentId) {
        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);
        var statusSelect = form.querySelector('select[name="status_id"]');
        var selectedStatus = statusSelect.options[statusSelect.selectedIndex];
        var newStatusName = selectedStatus.text;
        formData.append('document_id', documentId);

        // Send an asynchronous request to the change_status.php file
        fetch('change_status.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                if (response.ok) {
                    // Update the status dynamically
                    updateStatus(documentId, newStatusName);
                    alert('Status successfully updated to ' + newStatusName);
                } else {
                    alert('Error updating status');
                }
            })
            .catch(function(error) {
                console.log(error);
                alert('Error updating status');
            });
    }
</script>

<style>
    .action-button {
        text-decoration: none;
        padding: 8px 22px;
        margin: 10px;
        border: 1px solid black;
        border-radius: 6px;
        background-color: white;
        color: #000;
        cursor: pointer;
        font-size: 1.5rem;
    }

    .action-button:hover {
        background-color: #000;
        color: #fff;
    }

    .custom-select {
        padding: 8px;
        margin: 10px;
        border: 1px solid black;
        border-radius: 6px;
        background-color: white;
        color: #000;
        cursor: pointer;
        font-size: 1.5rem;
    }
</style>
























<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form onsubmit=\"changeStatus(event, $documentId); return false;\" style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id' required>
                        <option disabled selected value=''>Select an Status</option>"; // Added echo statement here

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit'>Update Status</button>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    // function printDocument(documentPath) {
    //     var printWindow = window.open('', '_blank');
    //     printWindow.document.write("<html><head><title>Print Document</title></head><body>");
    //     printWindow.document.write("<style>body { display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; }</style>");
    //     printWindow.document.write("<h2>Faculty Name: <?php echo $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name']; ?></h2>");
    //     printWindow.document.write("<h2>Document Category: <?php echo $categoryName; ?></h2>");
    //     printWindow.document.write("<iframe src=\"" + documentPath + "\" width=\"100%\" height=\"100%\"></iframe>");
    //     printWindow.document.write("<div style=\"display: flex; justify-content: center; cursor: pointer;\"><a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"print();\">Print</a></div>");
    //     printWindow.document.write("</body></html>");
    //     printWindow.document.close();

    //     printWindow.addEventListener('load', function() {
    //         printWindow.print();
    //     });
    // }

    function updateStatus(documentId, newStatusName) {
        var statusElement = document.getElementById('status_' + documentId);
        if (statusElement) {
            statusElement.textContent = newStatusName;
        }
    }

    function changeStatus(event, documentId) {
        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);
        var statusSelect = form.querySelector('select[name="status_id"]');
        var selectedStatus = statusSelect.options[statusSelect.selectedIndex];
        var newStatusName = selectedStatus.text;
        formData.append('document_id', documentId);

        // Send an asynchronous request to the change_status.php file
        fetch('change_status.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                if (response.ok) {
                    // Update the status dynamically
                    updateStatus(documentId, newStatusName);
                    alert('Status successfully updated to ' + newStatusName);
                } else {
                    alert('Error updating status');
                }
            })
            .catch(function(error) {
                console.log(error);
                alert('Error updating status');
            });
    }
</script>
 -->












<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form onsubmit=\"changeStatus(event, $documentId); return false;\" style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id' required>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit'>Change Status</button>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    function updateStatus(documentId, newStatusName) {
        var statusElement = document.getElementById('status_' + documentId);
        if (statusElement) {
            statusElement.textContent = newStatusName;
        }
    }

    function changeStatus(event, documentId) {
        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);
        var statusSelect = form.querySelector('select[name="status_id"]');
        var selectedStatus = statusSelect.options[statusSelect.selectedIndex];
        var newStatusName = selectedStatus.text;
        formData.append('document_id', documentId);

        // Send an asynchronous request to the change_status.php file
        fetch('change_status.php', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                if (response.ok) {
                    // Update the status dynamically
                    updateStatus(documentId, newStatusName);
                    alert('Status successfully updated to ' + newStatusName);
                } else {
                    alert('Error updating status');
                }
            })
            .catch(function (error) {
                console.log(error);
                alert('Error updating status');
            });
    }
</script> -->
































<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form action='change_status.php' method='post' style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id'>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit'>Change Status</button>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    function updateStatus(documentId, newStatusName) {
        var statusElement = document.getElementById('status_' + documentId);
        if (statusElement) {
            statusElement.textContent = newStatusName;
        }
    }
</script> -->



<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form action='change_status.php' method='post' style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id'>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit'>Change Status</button>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }
</script> -->



<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form id='form_$documentId' style='display: none;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id' onchange='changeStatus($documentId, this.value)'>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    function changeStatus(documentId, statusId) {
        var statusElement = document.getElementById('status_' + documentId);
        statusElement.innerHTML = 'Loading...';

        // Send an AJAX request to update the status
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'change_status.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                statusElement.innerHTML = xhr.responseText;
            } else {
                statusElement.innerHTML = 'Error';
            }
        };
        xhr.send('document_id=' + documentId + '&status_id=' + statusId);
    }

    window.onload = function() {
        var forms = document.getElementsByTagName('form');
        for (var i = 0; i < forms.length; i++) {
            forms[i].style.display = 'block';
        }
    };
</script> -->
























<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: <span id='status_$documentId'>$statusName</span></h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";

            // Add a form to change the status
            echo "<form action='change_status.php' method='post' style='display: flex; justify-content: center;'>
                    <input type='hidden' name='document_id' value='$documentId'>
                    <select name='status_id' onchange='changeStatus($documentId, this.value)'>";

            // Retrieve status data from the database
            $statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
            $statusResult = mysqli_query($conn, $statusSql);
            while ($status = mysqli_fetch_assoc($statusResult)) {
                $statusId = $status['status_id'];
                $statusName = $status['name'];
                echo "<option value='$statusId'>$statusName</option>";
            }

            echo "</select>
                    <button type='submit'>Change Status</button>
                </form>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }

    function changeStatus(documentId, statusId) {
        var statusElement = document.getElementById('status_' + documentId);
        statusElement.innerHTML = 'Loading...';

        // Send an AJAX request to update the status
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'change_status.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                statusElement.innerHTML = xhr.responseText;
            } else {
                statusElement.innerHTML = 'Error';
            }
        };
        xhr.send('document_id=' + documentId + '&status_id=' + statusId);
    }
</script> -->

























<!-- < ?php
// Database connection
// Include sensitive data
require_once 'dbconnection.php';

// Retrieve the faculty_id from the URL query parameter
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';

// Retrieve faculty data from the database
$facultySql = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = '$faculty_id'";
$facultyResult = mysqli_query($conn, $facultySql);
$facultyRow = mysqli_fetch_assoc($facultyResult);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected category ID from the POST request
    $selectedCategoryId = $_POST['document'];

    // Perform database query to retrieve the documents based on the selected category and faculty_id
    $documentSql = "SELECT d.`doc_id`, d.`file_name`, d.`file_path`, d.`category_id`, d.`faculty_id`, d.`status_id`, c.`name` AS category_name, s.`name` AS status_name
                    FROM `documents` d
                    INNER JOIN `doccategories` c ON d.`category_id` = c.`category_id`
                    INNER JOIN `status` s ON d.`status_id` = s.`status_id`
                    WHERE d.`category_id` = '$selectedCategoryId' AND d.`faculty_id` = '$faculty_id'";
    $documentResult = mysqli_query($conn, $documentSql);

    // Display the retrieved documents if available
    if (mysqli_num_rows($documentResult) > 0) {
        while ($row = mysqli_fetch_assoc($documentResult)) {
            $documentId = $row['doc_id'];
            $documentName = $row['file_name'];
            $documentPath = $row['file_path'];
            $categoryName = $row['category_name'];
            $statusName = $row['status_name'];

            // Output the document details and directly display the document
            echo "<div style=\"display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%; flex-direction: column;\">
                    <h2>Faculty Name: " . $facultyRow['first_name'] . ' ' . $facultyRow['middle_name'] . ' ' . $facultyRow['last_name'] . "</h2>
                    <h2>Document Category: $categoryName</h2>
                    <h2>Document Name: $documentName</h2>
                    <h2>Status: $statusName</h2>
                    <iframe src=\"$documentPath\" width=\"100%\" height=\"100%\"></iframe>
                </div>";

            echo "<div style=\"display: flex; justify-content: center; cursor: pointer;\">
                    <a href=\"javascript:void(0);\" style=\"text-decoration: none; padding: 8px 22px; margin: 10px; border: 1px solid black; border-radius: 6px; background-color: white; color: #000; cursor: pointer; font-size: 1.5rem;\" onmouseover=\"this.style.backgroundColor='#000'; this.style.color='#fff';\" onmouseout=\"this.style.backgroundColor='white'; this.style.color='#000';\" onclick=\"printDocument('$documentPath');\">Print</a>
                    </div>";
        }
    } else {
        echo "No documents available for the selected category and faculty.";
    }
}

// Retrieve category data from the database
$categorySql = "SELECT * FROM doccategories WHERE 1";
$categoryResult = mysqli_query($conn, $categorySql);
?>

<script>
    function printDocument(documentPath) {
        var printWindow = window.open(documentPath, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }
</script> -->

<!-- 

< ?php
// Retrieve status data from the database
$statusSql = "SELECT `status_id`, `name` FROM `status` WHERE 1";
$statusResult = mysqli_query($conn, $statusSql);
$statusData = mysqli_fetch_all($statusResult, MYSQLI_ASSOC);

// Generate <option> tags for each category
while ($categoryData = mysqli_fetch_assoc($categoryResult)) {
    $categoryId = $categoryData['category_id'];
    $categoryName = $categoryData['name'];

    echo "<option value='$categoryId'>$categoryName</option>";

    // Generate <option> tags for each status
    echo "<select name='status[$categoryId]'>";
    foreach ($statusData as $status) {
        $statusId = $status['status_id'];
        $statusName = $status['name'];
        echo "<option value='$statusId'>$statusName</option>";
    }
    echo "</select>";
}

// Submit button to change status
echo "<input type='submit' name='changeStatus' value='Change Status'>";

// Check if the status change form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changeStatus'])) {
    // Retrieve the selected status values
    $selectedStatus = $_POST['status'];

    // Update the status for each category
    foreach ($selectedStatus as $categoryId => $statusId) {
        // Perform the status update query
        $updateStatusSql = "UPDATE `documents` SET `status_id` = '$statusId' WHERE `category_id` = '$categoryId' AND `faculty_id` = '$faculty_id'";
        $updateStatusResult = mysqli_query($conn, $updateStatusSql);

        // Check if the status update was successful
        if ($updateStatusResult) {
            echo "Status updated successfully for Category ID: $categoryId";
        } else {
            echo "Failed to update status for Category ID: $categoryId";
        }
    }
}


?> -->