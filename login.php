<?php
// Start the session
session_start();

// config.php
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
        // Add debug statement to check session variables
        echo "Session variables set:<br>";
        var_dump($_SESSION);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
    <style>
        body {
            background-color: rgba(202, 223, 244, 1);
        }
        footer {
        background-color: #f5f5f5;
        padding: 20px;
        border-top: 1px solid #ddd;
        margin-top: 50px;
        clear: both;
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
        justify-content: space-between;
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
    </style>
</head>
<body>
    <div class="techgenius-academy-unlock-your-potential-empower-your-future">
        <span style="font-family: Orbitron, sans-serif; font-weight: 900; color: rgba(0, 123, 255, 1);">
            TECHGENIUS ACADEMY
        </span>
        <br />
        
        <span style="font-size: 24px; color: rgba(0,123,255,1);">
                    Unlock Your Potential, Empower Your Future!
        </span>
    </div><br />
    <!-- Bootstrap login form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">TechGenius Academy Login</h4>
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="admin">Admin</option>
                                    <option value="teachers">Teacher</option>
                                    <option value="students">Student</option>
                                </select>
                            </div></br>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <div class="dont-have-an-account-register">
                                <span style="color: rgba(0,123,255,1);">
                                    Don’t have an account?
                                </span>
                                <br />
                                <span style="font-style: italic; color: rgba(0,123,255,1);">
                                    <a href="register.php">REGISTER</a>
                                </span>
                            </div>
                        </form>
                        <?php if (isset($error)) { echo '<p class="text-danger">' . $error . '</p>'; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-container">
            <div class="footer-left">
            <p>&copy; 2023 School Management System</p>
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
</body>
</html>
