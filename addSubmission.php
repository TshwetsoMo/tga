<?php
// Check if the user is logged in and has the student role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'students') {
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

// Get the student's name and ID from the database
$query = "SELECT studentName, studentID FROM students WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $student_name = $row['studentName'];
    $_SESSION['studentID'] = $row['studentID']; // Store the student ID in the session
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();

// Get the assignmentID from GET or POST
if (isset($_GET['assignmentID'])) {
    $assignmentID = $_GET['assignmentID'];
} elseif (isset($_POST['assignmentID'])) {
    $assignmentID = $_POST['assignmentID'];
} else {
    $assignmentID = null;
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignmentID = $_POST['assignmentID'];
    $fileName = basename($_FILES['file']['name']);
    $tmpFilePath = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    // Check if the file is valid
    if ($fileSize > 0 && $fileType == 'application/pdf') {
        $uploadDir = 'uploads/';
        // Ensure the uploads directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate a unique file name to avoid overwriting
        $fileDestination = $uploadDir . uniqid() . '_' . $fileName;

        // Check if the file upload was successful
        if (move_uploaded_file($tmpFilePath, $fileDestination)) {
            // File upload successful, proceed with database insertion
            // Insert submission into the database
            $query = "INSERT INTO submissions (submissionDate, filePath, marksObtained, feedback, assignmentID, studentID) 
                    VALUES (NOW(), ?, 0, '', ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $fileDestination, $assignmentID, $_SESSION['studentID']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirect to studentshome.php
                header('Location: studentshome.php');
                exit;
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Error: File upload failed.";
        }
    } else {
        $error_message = "Error: Invalid file format or size. Only PDF files are allowed.";
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Assignment - TechGenius Academy</title>
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
            /* Background Image */
            background-image: url('https://wallpapers.com/images/featured/anime-school-background-dh3ommnxthw4nln7.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
        }
        /* Overlay to enhance readability */
        .overlay {
            background-color: rgba(255, 255, 255, 0.4);
            width: 100%;
            min-height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
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
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: rgba(0, 105, 217, 0.95);
            padding: 20px;
            border-right: 3px solid rgba(255, 193, 7, 0.8);
            overflow-y: auto;
            z-index: 1000;
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
            position: relative;
            z-index: 1;
        }
        .header-banner {
            width: 100%;
            text-align: center;
            background-color: rgba(0, 105, 217, 0.9);
            color: #fff;
            padding: 20px 0;
            margin-bottom: 20px;
            border-radius: 10px;
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
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-message h1 {
            font-family: 'Orbitron', sans-serif;
            color: rgba(0, 105, 217, 1);
            background-color: rgba(255, 255, 255, 0.8);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
        }
        /* Form Styles */
        .submission-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
        }
        .submission-form .form-group label {
            font-weight: bold;
        }
        .submission-form .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px 20px;
        }
        .submission-form .btn-primary:hover {
            background-color: #e0a800;
            color: #000;
        }
        /* Footer */
        footer {
            background-color: rgba(0, 105, 217, 0.95);
            padding: 20px;
            color: #fff;
            text-align: center;
            position: relative;
            border-top: 3px solid rgba(255, 193, 7, 0.8);
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
                z-index: 0;
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
    <!-- Overlay Start -->
    <div class="overlay"></div>
    <!-- Overlay End -->
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="school-logo">
            <img src="logo.png" alt="School Logo" class="img-fluid rounded-circle">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="studentshome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <!-- Navbar Items with Icons -->
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-book"></i> My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-tasks"></i> Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="grades.php"><i class="fas fa-chart-line"></i> My Grades</a>
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
        <!-- Welcome Message -->
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($student_name); ?> (Student)</h1>
        </div>
        <!-- Submission Form -->
        <div class="submission-form">
            <?php if (isset($error_message)) { echo '<div class="alert alert-danger">' . htmlspecialchars($error_message) . '</div>'; } ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="assignmentID" value="<?php echo htmlspecialchars($assignmentID); ?>">
                <div class="form-group">
                    <label for="assignmentTitle">Assignment Title:</label>
                    <?php
                    // Fetch assignment title from the database
                    if ($assignmentID) {
                        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
                        $query = "SELECT title FROM assignments WHERE assignmentID = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $assignmentID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<input type="text" class="form-control" id="assignmentTitle" value="' . htmlspecialchars($row['title']) . '" disabled>';
                        } else {
                            echo '<input type="text" class="form-control" id="assignmentTitle" value="Assignment not found" disabled>';
                        }
                        $stmt->close();
                        $conn->close();
                    } else {
                        echo '<input type="text" class="form-control" id="assignmentTitle" value="No assignment selected" disabled>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="file">Upload Your Assignment (PDF only):</label>
                    <input type="file" class="form-control-file" id="file" name="file" accept=".pdf" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit Assignment</button>
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

