</head>

<body>
    <?php
    // Include sensitive data
    require_once '../assets/db/dbconnection.php';
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['faculty_id'])) {
        // Redirect to the login page or any other desired page
        header('Location: ../login.php');
        exit;
    } else {
        // Retrieve the faculty_id from the session
        $facultyId = $_SESSION['faculty_id'];

        // Prepare the SELECT query
        $sql = "SELECT * FROM `faculty` WHERE faculty_id = $facultyId";

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
                    <span>NLC Faculty</span>
                </div>

                <!-- ToggleNav -->

                <!-- <i class="fa-solid fa-bars" onclick="toggleNav()"></i> -->

                <i class="fa-solid fa-bars" onclick="toggleNav(this)"></i>

                <div class="nav-items" id="navitems">
                    <a class="nav-item" href="facmyprofile.php">
                        <span>
                            My profile
                        </span>
                    </a>
                    <a class="nav-item" href="facdocument.php">
                        <span>
                            Document
                        </span>
                    </a>
                    
                    <a class="nav-item" href="facsettings.php">
                        <span>
                            Settings
                        </span>
                    </a>
                    <a class="nav-item" href="fachelpandsupport.php">
                        <span>
                            Help and support
                        </span>
                    </a>
                    <a class="nav-item" href="../assets/db/faclogout.php">
                        <span>
                            Log out
                        </span>
                    </a>

                </div>

            </div>
        </nav>

        <div class="main-body">
            <div class="header">