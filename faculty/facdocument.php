<!-- START -->

<?php
// Database connection
require_once '../assets/db/dbconnection.php';
?>

<!-- HTML Head -->
<?php include '../assets/include/head.php'; ?>
<!-- HTML Head -->

<!-- CSS link -->

<!-- css sidenavbar -->
<link rel="stylesheet" href="../assets/css/facultynavbar.css">

<!-- css main-body contain -->
<link rel="stylesheet" href="../assets/css/facdocument.css">

<!-- css footer -->
<link rel="stylesheet" href="../assets/css/facultyfooter.css">

<!-- Page Title -->
<title>Faculty Document</title>

<!-- SIDENAVBAR -->
<?php include '../assets/include/facultynavbar.php'; ?>
<!-- SIDENAVBAR -->

<!-- MAIN BODY CONTAIN START -->
<h1>Document</h1>
</div>

<div class="container">

    <div class="up-doc">
        <form action="../assets/db/upload_file.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <legend>Upload File</legend>

            <label for="file">Select a file to upload:</label>
            <input class="file-up" type="file" accept=".pdf, .doc, .docx, .odt, image/*" id="file" name="file" required>

            <label for="category">Select a category:</label>
            <?php
            // Fetch categories from the database
            $query = "SELECT category_id, name FROM doccategories";
            $result = mysqli_query($conn, $query);

            // Generate <option> elements for each category
            $options = '<option value="" disabled selected>Select a category</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryId = $row['category_id'];
                $categoryName = $row['name'];
                $options .= '<option value="' . $categoryId . '">' . $categoryName . '</option>';
            }
            ?>

            <select id="category" name="category">
                <?php echo $options; ?>
            </select>

            <input class="btn-up" type="submit" value="Upload" id="uploadBtn" disabled>

            <script>
                // Enable/disable the upload button based on the selected category and file
                const categorySelect = document.getElementById('category');
                const fileInput = document.getElementById('file');
                const uploadBtn = document.getElementById('uploadBtn');

                categorySelect.addEventListener('change', validateForm);
                fileInput.addEventListener('change', validateForm);

                function validateForm() {
                    const categoryValue = categorySelect.value;
                    const file = fileInput.files[0];

                    // Check if category and file are selected
                    if (categoryValue !== '' && file) {
                        uploadBtn.disabled = false;
                    } else {
                        uploadBtn.disabled = true;
                    }
                }
            </script>

        </form>

        <script>
            // Check if the URL contains the success parameter
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');

            // Display an alert if the success parameter is present
            if (success === '1') {
                alert('File uploaded successfully.');
            }
        </script>
    </div>

    <div class="display">
        <?php
        // Check if the faculty_id is stored in the session
        if (isset($_SESSION['faculty_id'])) {
            $faculty_id = $_SESSION['faculty_id'];

            // Fetch and display uploaded files with category and status information
            $query = "SELECT d.file_name, d.document_key, d.file_path, c.name AS category_name, s.name AS status_name
                      FROM documents d
                      JOIN doccategories c ON d.category_id = c.category_id
                      JOIN status s ON d.status_id = s.status_id
                      WHERE d.faculty_id = '$faculty_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Serial No</th><th>Category</th><th>File Name</th><th>Status</th><th>View</th></tr>';

                $serialNo = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $fileName = $row['file_name'];
                    $categoryName = $row['category_name'];
                    $documentKey = $row['document_key'];
                    $filePath = $row['file_path'];
                    $statusName = $row['status_name'];
                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

                    // Ensure the file path is correct
                    $fullFilePath = '../uploads/' . $filePath; // Adjust path based on your setup

                    echo '<tr>';
                    echo '<td>' . $serialNo . '</td>';
                    echo '<td>' . $categoryName . '</td>';
                    echo '<td>' . $fileName . '</td>';
                    echo '<td>' . $statusName . '</td>';
                    echo '<td>';

                    // Add view button based on file type (PDF or Image)
                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        // Display "View Image" button for images
                        echo '<button onclick="openFile(\'' . $fullFilePath . '\', \'image\')">View Image</button>';
                    } elseif ($fileExtension === 'pdf') {
                        // Display "View PDF" button for PDFs
                        echo '<button onclick="openFile(\'' . $fullFilePath . '\', \'pdf\')">View PDF</button>';
                    } else {
                        // Display download button for other file types
                        echo '<a href="../assets/db/facdownload.php?document_key=' . $documentKey . '" download>Download</a>';
                    }

                    echo '</td>';
                    echo '</tr>';

                    $serialNo++;
                }

                echo '</table>';
            } else {
                echo 'No files found.';
            }
        } else {
            echo 'Faculty ID not found in session.';
        }
        ?>
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

<!-- JavaScript for viewing files -->
<script>
    function openFile(filePath, fileType) {
        if (fileType === 'image') {
            // Open the image in a new window
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<img src="' + filePath + '" alt="Image" style="width:100%;height:auto;">');
        } else if (fileType === 'pdf') {
            // Open the PDF in a new window
            window.open(filePath, '_blank');
        }
    }
</script>

<!-- END -->
