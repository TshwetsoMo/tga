<?php
// Check if the user is logged in and has the teacher role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teachers') {
    header('Location: login.php');
    exit;
}

// Define database connection variables
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'tga';

// Connect to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the teacher's ID from the session
$teacher_id = $_SESSION['teacherID'];

// Check if the teacher ID is set and not empty
if (isset($teacher_id) && !empty($teacher_id)) {
    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseID = $_POST['courseID'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $dueDate = $_POST['dueDate'];
        $totalMarks = $_POST['totalMarks'];

        // Insert the assignment into the database
        $query = "INSERT INTO assignments (courseID, title, description, dueDate, totalMarks, teacherID) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssi", $courseID, $title, $description, $dueDate, $totalMarks, $teacher_id);
        $stmt->execute();

        // Check if the assignment was added successfully
        if ($stmt->affected_rows > 0) {
            // Redirect to teachershome.php
            header('Location: teacherhome.php');
            exit;
        } else {
            $error_message = "Error adding assignment: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error_message = "Teacher ID is not set or is empty.";
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Assignment - TechGenius Academy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            background-color: rgba(255, 255, 255, 0.4);
            /* Background Image */
            background-image: url('https://wallpapers.com/images/hd/anime-school-scenery-empty-classroom-oemz67vnyqdihizw.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: overlay;
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
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: #0069d9;
            padding: 20px;
            border-right: 3px solid rgba(255, 193, 7, 0.8);
            overflow-y: auto;
        }
        .sidebar .school-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar .school-logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #fafafa;
        }
        .sidebar .nav {
            flex-direction: column;
        }
        .sidebar .nav-item {
            margin-bottom: 10px;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 193, 7, 0.8);
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .logout-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        .logout-button a {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .logout-button a:hover {
            color: rgba(255, 193, 7, 0.8);
        }
        /* Main content area */
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .header-banner {
            width: 100%;
            text-align: center;
            background-color: #0069d9;
            color: #fff;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .header-banner .title {
            font-size: 36px;
            font-weight: 900;
            font-family: 'Orbitron', sans-serif;
            margin: 0;
        }
        .header-banner .subtitle {
            font-size: 24px;
            margin: 0;
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .page-title h1 {
            font-family: 'Orbitron', sans-serif;
            color: #0069d9;
        }
        /* Form Styles */
        .assignment-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
        }
        .assignment-form .form-group label {
            font-weight: bold;
        }
        .assignment-form .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px 20px;
        }
        .assignment-form .btn-primary:hover {
            background-color: #e0a800;
            color: #000;
        }
        /* Footer */
        footer {
            background-color: #0069d9;
            padding: 20px;
            color: #fff;
            text-align: center;
            position: relative;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
        }
        footer a:hover {
            color: #e0a800;
        }
        footer .footer-logo {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        footer .footer-logo img {
            width: 50px;
            height: 50px;
        }
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
            footer .footer-logo {
                position: static;
                transform: none;
                margin-bottom: 10px;
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
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="school-logo">
            <img src="logo.png" alt="School Logo" class="img-fluid rounded-circle">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="teachershome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <!-- Navbar Items -->
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="fas fa-tasks"></i> Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-file-upload"></i> Submissions</a>
            </li>
            <!-- Announcements -->
            <li class="nav-item">
                <a class="nav-link" href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <!-- Sidebar End -->
    <!-- Main Content Start -->
    <div class="main-content">
        <!-- Header Banner -->
        <div class="header-banner">
            <span class="title">TECHGENIUS ACADEMY</span>
            <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
        </div>
        <!-- Page Title -->
        <div class="page-title">
            <h1>Add Assignment</h1>
        </div>
        <!-- Assignment Form -->
        <div class="assignment-form">
            <?php if (isset($error_message)) { echo '<div class="alert alert-danger">' . htmlspecialchars($error_message) . '</div>'; } ?>
            <form method="post">
                <div class="form-group">
                    <label for="courseID">Course ID:</label>
                    <input type="text" class="form-control" id="courseID" name="courseID" required>
                </div>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="dueDate">Due Date:</label>
                    <input type="date" class="form-control" id="dueDate" name="dueDate" required>
                </div>
                <div class="form-group">
                    <label for="totalMarks">Total Marks:</label>
                    <input type="number" class="form-control" id="totalMarks" name="totalMarks" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Assignment</button>
            </form>
        </div>
        <!-- Footer -->
        <footer>
            <!-- Small School Logo -->
            <div class="footer-logo">
                <img src="logo.png" alt="School Logo">
            </div>
            <p>&copy; 2023 TechGenius Academy | <a href="#">About Us</a> | <a href="#">Contact Us</a> | <a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
    <!-- Main Content End -->
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
