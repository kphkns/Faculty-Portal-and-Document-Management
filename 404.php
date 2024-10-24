<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Add a Favicon -->
    <link rel="shortcut icon" href="assets/img/nlcfavicon.ico" type="image/x-icon">

    <meta http-equiv="refresh" content="5;url=/docmanagement/login.php">

    <title>404 Not Found</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .container {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .banner {
            background-color: #333;
            padding: 6px 0;
            text-align: center;
        }

        .banner img {
            max-width: 100%;
            height: auto;
        }

        h1 {
            font-weight: bold;
            font-size: 4rem;
            padding: 6px;
        }

        .home {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .home p {
            padding: 6px 0px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .footer {
            background-color: #333;
            padding: 16px 0;
            text-align: center;
            color: #fff;
            font-size: 12px;
        }

        /* Media Queries for Mobile and Tablet */
        @media only screen and (max-width: 767px) {
            h1 {
                font-weight: bold;
                font-size: 2rem;
                padding: 6px;
            }

            .home p {
                padding: 6px 20px;
                font-weight: bold;
                font-size: 1.1rem;
            }
        }
    </style>

</head>

<body>

    <div class="banner">
        <img src="/docmanagement/assets/img/logoheader.png" alt="Banner Image">
    </div>

    <div class="container">

        <h1>404 Not Found</h1>

        <img src="/docmanagement/assets/img/404.gif" alt="404img">

        <div class="home">

            <p>The page you are looking for does not exist.</p>
            <p>You will be redirected to the home page in 5 seconds. If not, click
                <a href="/docmanagement/login.php">here</a>.
            </p>

        </div>
    </div>

    <div class="footer">
        <footer>
            <p class="footer-text">&copy; <span id="currentYear"></span> Document Management System by Basanta
                Kakoti and Bishal Saikia. All rights reserved.</p>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let currentYear = new Date().getFullYear();
                    let currentYearSpan = document.querySelector("#currentYear");
                    currentYearSpan.innerHTML = currentYear;
                });
            </script>
        </footer>
    </div>

</body>

</html>