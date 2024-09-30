<?php
// Start the session
session_start();

// Database connection settings
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'tga';

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM $role WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, create a session and redirect to home page
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;

        if ($role == 'admin') {
            // Retrieve the admin's ID from the database
            $query = "SELECT adminID FROM admin WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();
            $_SESSION['adminID'] = $admin['adminID'];
        }

        if ($role == 'teachers') {
            // Retrieve the teacher's ID from the database
            $query = "SELECT teacherID FROM teachers WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $teacher = $result->fetch_assoc();
            $_SESSION['teacherID'] = $teacher['teacherID'];
            $_SESSION['teacherEmail'] = $email; // Store the teacher's email in the session as well
        }

        header('Location: ' . $role . 'home.php');
        exit;
    } else {
        // Invalid credentials, display error message
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <title>TechGenius Academy Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }
        /* Spinner Styles */
        #spinner {
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        #spinner.show {
            opacity: 1;
            visibility: visible;
        }
        #spinner.hide {
            opacity: 0;
            visibility: hidden;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .header-banner {
            width: 100%;
            height: 120px;
            text-align: center;
            background-color: #0069d9;
            color: #fff;
            padding: 20px 0;
        }
        .header-banner span {
            display: block;
        }
        .header-banner .title {
            font-size: 36px;
            font-weight: 900;
            font-family: 'Orbitron', sans-serif;
        }
        .header-banner .subtitle {
            font-size: 24px;
            font-family: 'Roboto', sans-serif;
        }
        .login-container {
            margin-top: 50px;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        .login-img {
            background-image: url('img/about.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
        }
        .login-form {
            padding: 30px;
            background-color: #fff;
            height: 100%;
        }
        .login-form h4 {
            font-weight: bold;
            margin-bottom: 20px;
            font-family: 'Orbitron', sans-serif;
        }
        .login-form .form-control {
            border-radius: 20px;
        }
        .btn-login {
            border-radius: 20px;
            background-color: #0069d9;
            border: none;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .register-link {
            margin-top: 10px;
            text-align: center;
        }
        .register-link a {
            color: #0069d9;
            font-weight: bold;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #f5f5f5;
            padding: 20px;
            border-top: 1px solid #ddd;
            margin-top: 50px;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }
        .footer-left {
            font-size: 14px;
            color: #666;
        }
        .footer-right ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .footer-right li {
            margin-right: 20px;
        }
        .footer-right a {
            color: #337ab7;
            text-decoration: none;
        }
        .footer-right a:hover {
            color: #23527c;
        }
        @media (max-width: 767.98px) {
            .login-img {
                display: none;
            }
            .login-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Header Banner -->
    <div class="header-banner">
        <span class="title">TECHGENIUS ACADEMY</span>
        <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
    </div>
    <!-- Login Container -->
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card login-card">
                    <div class="row no-gutters">
                        <div class="col-md-6 login-img">
                            <!-- Background image is set in CSS -->
                        </div>
                        <div class="col-md-6">
                            <div class="login-form">
                                <h4>Login</h4>
                                <form action="login.php" method="post">
                                    <?php if (isset($error)) { echo '<p class="text-danger">' . $error . '</p>'; } ?>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role:</label>
                                        <select id="role" name="role" class="form-control" required>
                                            <option value="admin">Admin</option>
                                            <option value="teachers">Teacher</option>
                                            <option value="students">Student</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-login btn-block">Login</button>
                                    <div class="register-link">
                                        <p>Don’t have an account? <a href="register.php">REGISTER</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <p>&copy; 2023 TechGenius Academy</p>
            </div>
            <div class="footer-right">
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- jQuery and Bootstrap JS (Required for the spinner and functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Spinner Script -->
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $('#spinner').addClass('hide');
            }, 500); // Adjust the timeout as needed
        });
    </script>
</body>
</html>

