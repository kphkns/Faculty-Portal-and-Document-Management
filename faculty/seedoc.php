<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>File Uploader</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Upload and View Files</h1>

    <!-- File Upload Section -->
    <input type="file" id="fileInput" multiple>
    <ul id="fileList"></ul>
  </div>

  <script src="script.js"></script>
</body>
<style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 20px;
  background-color: #f4f4f9;
}

.container {
  max-width: 600px;
  margin: 0 auto;
}

h1 {
  text-align: center;
}

input[type="file"] {
  display: block;
  margin: 20px auto;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #fff;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 5px 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

</style>

<script>// Get the file input and the list where files will be displayed
const fileInput = document.getElementById('fileInput');
const fileList = document.getElementById('fileList');

// Add event listener for file upload
fileInput.addEventListener('change', function () {
  fileList.innerHTML = ''; // Clear the list
  const files = Array.from(fileInput.files); // Convert file list to array

  files.forEach((file, index) => {
    const listItem = document.createElement('li');
    
    // Create a name text for the file
    const fileName = document.createElement('span');
    fileName.textContent = file.name;

    // Create a view button
    const viewButton = document.createElement('button');
    viewButton.textContent = 'See Doc';
    viewButton.addEventListener('click', function () {
      viewFile(file);
    });

    // Append the file name and button to the list item
    listItem.appendChild(fileName);
    listItem.appendChild(viewButton);

    // Append the list item to the file list
    fileList.appendChild(listItem);
  });
});

// Function to view the file
function viewFile(file) {
  const fileURL = URL.createObjectURL(file);

  // Create a new window/tab and open the file (PDF, image, etc.)
  const newWindow = window.open();
  if (file.type.startsWith('image/')) {
    // Display image
    newWindow.document.write(`<img src="${fileURL}" alt="${file.name}" style="width:100%;"/>`);
  } else if (file.type === 'application/pdf') {
    // Display PDF
    newWindow.document.write(`<embed src="${fileURL}" type="application/pdf" width="100%" height="100%"/>`);
  } else {
    // If it's another file type, download it
    newWindow.document.write(`<p>Cannot display this file. <a href="${fileURL}" download="${file.name}">Click to download</a>.</p>`);
  }
}
</script>
</html>
