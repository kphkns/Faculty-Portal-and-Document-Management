</head>

<body>
    <?php
    // Include sensitive data
    require_once '../assets/db/dbconnection.php';
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['admin_id'])) {
        // Redirect to the login page or any other desired page
        header('Location: ../login.php');
        exit;
    } else {
        // Retrieve the admin_id from the session
        $adminId = $_SESSION['admin_id'];

        // Prepare the SELECT query
        $sql = "SELECT * FROM `admin` WHERE admin_id = $adminId";

    }

    ?>

    <div class="banner">
        <img src="../assets/img/logoheader.png" alt="Banner Image">
    </div>

    <div class="wrapper">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="../assets/img/logo.png" alt="logo">
                    <span>NLC ADMIN</span>
                </div>

                <a href="../admin/admindashboard.php">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-item">Dashboard</span>
                </a>

                <a href="../admin/adminfaculty.php">
                    <i class="fa-solid fa-user"></i>
                    <span class="nav-item">Faculty</span>
                </a>

                <a href="../admin/admindocument.php">
                    <i class="fa-solid fa-file"></i>
                    <span class="nav-item">Document</span>
                </a>

                <a href="../admin/admindepartment.php">
                    <i class="fa-solid fa-id-badge"></i>
                    <span class="nav-item">Department</span>
                </a>

                <a href="../admin/admindesignation.php">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span class="nav-item">Designation</span>
                </a>

                <a href="../admin/adminsettings.php">
                    <i class="fa-solid fa-gear"></i>
                    <span class="nav-item">Settings</span>
                </a>

                <a href="../admin/adminhelpandsupport.php">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="nav-item">Help and Support</span>
                </a>

                <a href="../assets/db/adminlogout.php" class="logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-item">Log out</span>
                </a>

            </div>
        </nav>

        <div class="main-body">
            <div class="header">