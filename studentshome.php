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

// Get the student's name and ID from the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Home - TechGenius Academy</title>
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
        /* Announcements */
        .announcements {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .announcements h5 {
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 15px;
        }
        .announcements p {
            margin-bottom: 10px;
        }
        .announcements a {
            text-decoration: none;
            color: rgba(0, 105, 217, 1);
        }
        .announcements a:hover {
            color: #0056b3;
        }
        /* Uploaded Assignments */
        .uploaded-assignments, .assignments {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .uploaded-assignments h2, .assignments h2 {
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 20px;
        }
        .uploaded-assignments table, .assignments table {
            width: 100%;
            border-collapse: collapse;
        }
        .uploaded-assignments th, .assignments th, .uploaded-assignments td, .assignments td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .uploaded-assignments th, .assignments th {
            background-color: rgba(0, 105, 217, 0.9);
            color: #fff;
        }
        .uploaded-assignments tr:nth-child(even), .assignments tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .uploaded-assignments tr:hover, .assignments tr:hover {
            background-color: #f1f1f1;
        }
        .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            padding: 5px 10px;
        }
        .btn-primary:hover {
            background-color: #e0a800;
            color: #000;
        }
        .btn-primary a {
            color: #000;
            text-decoration: none;
        }
        .btn-primary a:hover {
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
                <a class="nav-link active" href="studentshome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <!-- Kept your existing navbar buttons and added icons -->
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
            <span class="title">TECHGENIUS ACADEMY</span></br>
            <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
        </div>
        <!-- Welcome Message -->
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($student_name); ?> (Student)</h1>
        </div>
        <!-- Announcements -->
        <div class="announcements">
            <h5>Announcements:</h5>
            <?php
            // Query to retrieve all announcements
            $query = "SELECT * FROM announcements ORDER BY postedDate DESC";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p><a href='announcements.php?id=" . $row['announcementID'] . "'>" . htmlspecialchars($row['title']) . "</a></p>";
                }
            } else {
                echo "<p>There are no announcements at this time.</p>";
            }
            ?>
        </div>
        <!-- Uploaded Assignments -->
        <div class="uploaded-assignments">
            <h2>Uploaded Assignments</h2>
            <?php
            // Query to retrieve uploaded assignments for the current student
            $studentID = $_SESSION['studentID'];
            $query = "SELECT * FROM submissions WHERE studentID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $studentID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the deletion was successful
            if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
                echo "<div class='alert alert-success'>Assignment deleted successfully!</div>";
            }

            if ($result && $result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Submission Date</th><th>Assignment ID</th><th>File Name</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $submissionID = $row['submissionID'];
                    $submissionDate = $row['submissionDate'];
                    $assignmentID = $row['assignmentID'];
                    $filePath = $row['filePath'];
                    $assignmentName = basename($filePath); // Get the file name from the path
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($submissionDate) . "</td>";
                    echo "<td>" . htmlspecialchars($assignmentID) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($filePath) . "' target='_blank'>" . htmlspecialchars($assignmentName) . "</a></td>";
                    echo "<td><a href='deleteSubmission.php?submissionID=" . $submissionID . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No uploaded assignments found.</p>";
            }
            ?>
        </div>
        <!-- Assignments Section -->
        <div class="assignments">
            <h2>My Assignments</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Assignment ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Posted Date</th>
                        <th>Due Date</th>
                        <th>Course ID</th>
                        <th>Submit</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Query to retrieve assignments for the student
                $query = "SELECT a.assignmentID, a.title, a.courseID, a.description, a.postedDate, a.dueDate 
                        FROM assignments a 
                        JOIN courseEnrollment ce ON a.courseID = ce.courseID 
                        JOIN students s ON ce.studentID = s.studentID 
                        WHERE s.email = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['assignmentID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['postedDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['dueDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['courseID']) . "</td>";
                        echo "<td><a href='addSubmission.php?assignmentID=" . $row['assignmentID'] . "&studentID=" . $_SESSION['studentID'] . "' class='btn btn-primary btn-sm'>Submit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No assignments found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
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
