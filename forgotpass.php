<!-- START -->

<!-- HTML Head -->
<?php include 'assets/include/head.php'; ?>
<!-- HTML Head -->

<!-- Add a Favicon -->
<link rel="shortcut icon" href="assets/img/nlcfavicon.ico" type="image/x-icon">

<!-- CSS link -->

<link rel="stylesheet" href="assets/css/forgotpass.css">

<!-- Page Title -->
<title>Forgot Password</title>

</head>

<body>

    <!-- MAIN BODY CONTAIN START -->

    <div class="container">

        <div class="banner">
            <img src="assets/img/logoheader.png" alt="Banner Image">
        </div>

        <div class="forgot">
            <form action="assets/db/forgotpasswordchange.php" method="post" onsubmit="return validateForm();">

                <legend>Forgot Password</legend>
                <table>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                        </td>
                        <td>
                            <input type="email" name="email" id="email" placeholder="Enter your email" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="phonenumber">Phone number</label>
                        </td>
                        <td>
                            <input type="tel" name="phone_number" id="phonenumber" placeholder="Enter your phone number"
                                pattern="[0-9]{10}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="dob">Date of birth</label>
                        </td>
                        <td>
                            <input type="date" name="birth_date" id="dob" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="new-password">New Password:</label>
                        </td>
                        <td>
                            <input type="password" name="password" id="password" placeholder="Enter your password"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="confirm-password">Confirm Password:</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Confirm Password" id="confirm_password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label id="captcha-question" for="captcha">Captcha: What is _ + _?</label>
                        </td>
                        <td>
                            <input type="number" id="captcha" name="captcha" required>
                            <input type="hidden" id="captcha-answer" name="captcha-answer">
                        </td>
                    </tr>
                </table>

                <input type="submit" class="button" value="Submit">

                <a href="login.php" class="line">Login Here</a>

            </form>

            <script>
                // Auto-generate captcha when the page loads
                window.onload = function () {
                    generateCaptcha();
                };

                function generateCaptcha() {
                    var num1 = Math.floor(Math.random() * 10) + 1;
                    var num2 = Math.floor(Math.random() * 10) + 1;
                    var captchaQuestion = "Captcha: What is " + num1 + " + " + num2 + "?";
                    document.getElementById("captcha-question").textContent = captchaQuestion;
                    document.getElementById("captcha-answer").value = num1 + num2;
                }

                function validateForm() {
                    var captchaInput = document.getElementById("captcha").value;
                    var captchaAnswer = document.getElementById("captcha-answer").value;

                    if (captchaInput == captchaAnswer) {
                        return true; // Proceed with form submission
                    } else {
                        alert("Invalid captcha. Please try again.");
                        return false; // Prevent form submission
                    }
                }
            </script>

            <!-- script for password and confirm_password -->

            <script>
                var password = document.getElementById("password"),
                    confirm_password = document.getElementById("confirm_password");

                function validatePassword() {
                    if (password.value != confirm_password.value) {
                        confirm_password.setCustomValidity("Passwords Don't Match");
                    } else {
                        confirm_password.setCustomValidity('');
                    }
                }

                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;
            </script>

        </div>

        <!-- Footer Here -->
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

    <!-- MAIN BODY CONTAIN END -->

</body>

</html>


<!-- END -->