# Faculty Document Management System

## Overview

The **Faculty Document Management System** is a web application designed to help manage faculty documents effectively. Built using HTML, CSS, and JavaScript, this system allows users to upload, view, and organize various document types, including PDFs, images, and Word documents.

## Features

- **Upload Files:** Faculty members can upload documents, including images and PDFs, to the system.
- **Document Organization:** Uploaded documents are categorized for easy management.
- **File Viewing:** Users can view uploaded documents directly through the application.
- **Database Integration:** The system connects to a MySQL database to store and manage document metadata.

## Getting Started

To set up the Faculty Document Management System locally, follow these steps:

### Prerequisites

- A web server (like XAMPP, WAMP, or MAMP) to run the PHP code.
- MySQL database management system.

### Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/kphkns/Faculty-Portal-and-Document-Management.git
   cd Faculty-Portal-and-Document-Management


Set Up the Database:

Create a new database named docmanagement.
Import the provided SQL file located in the sql folder into your docmanagement database. This SQL file contains the necessary tables and initial setup.
Configure Database Connection:

Open the dbconnection.php file located in the assets/db/ directory.
Update the database connection parameters to match your local environment:
php
Copy code
$servername = "localhost"; // or your server
$username = "your_username";
$password = "your_password";
$dbname = "docmanagement";
Run the Application:

Start your web server and navigate to the directory where the project is located.
Access the application in your web browser by going to http://localhost/path/to/your/project.
Technologies Used
HTML
CSS
JavaScript
PHP
MySQL
Contribution
Feel free to contribute to this project by submitting issues or pull requests. Your feedback and contributions are welcome!

License
This project is licensed under the MIT License - see the LICENSE file for details.

Acknowledgments
Thank you to everyone who contributed to the development of this system.
