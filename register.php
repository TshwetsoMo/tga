<!-- register.php -->
<?php
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

// Handle register form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to insert new user data
    $query = "INSERT INTO $role (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
    $result = $conn->query($query);

    if ($result) {
        // User created, display success message
        $success = "Account created successfully!";
    } else {
        // Error creating user, display error message
        $error = "Error creating account: " . $conn->error;
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">TechGenius Academy Register</h4>
                        <form action="register.php" method="post">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="admin">Admin</option>
                                    <option value="teachers">Teacher</option>
                                    <option value="students">Student</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname:</label>
                                <input type="text" id="surname" name="surname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control"></br>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                            </br>
                            <div class="dont-have-an-account-register">
                                <span style="color: rgba(0,123,255,1);">
                                    Already have an account?
                                </span>
                                <br />
                                <span style="font-style: italic; color: rgba(0,123,255,1);">
                                    <a href="login.php">LOGIN</a>
                                </span>
                            </div>
                        </form>
                        <?php if (isset($success)) { echo '<p class="text-success">' . $success . '</p>'; } ?>
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
