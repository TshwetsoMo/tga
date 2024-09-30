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

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the teacher's name and ID from the database
$query = "SELECT teacherName, teacherID FROM teachers WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $teacher_name = $row['teacherName'];
    $teacher_id = $row['teacherID']; // Retrieve the teacherID
} else {
    echo "Error: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Home - TechGenius Academy</title>
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
            overflow-x: hidden;background-color: rgba(255, 255, 255, 0.4);
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
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-message h1 {
            font-family: 'Orbitron', sans-serif;
            color: rgba(255, 193, 7, 0.8);
        }
        /* Announcements */
        .announcements {
            background-color: #fff;
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
            color: #0069d9;
        }
        .announcements a:hover {
            color: #0056b3;
        }
        /* Assignments Table */
        .assignments, .submissions {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .assignments h2, .submissions h2 {
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 20px;
        }
        .table thead th {
            background-color: #0069d9;
            color: #fff;
            text-align: center;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f2f2f2;
        }
        .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px 20px;
            margin-top: 20px;
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
                <a class="nav-link active" href="teachershome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <!-- Removed 'Manage Teachers', 'Manage Students', and 'Manage Courses' -->
            <!-- Added 'Assignments' and 'Submissions' -->
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-tasks"></i> Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-file-upload"></i> Submissions</a>
            </li>
            <!-- Kept 'Announcements' as is -->
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
            <span class="title">TECHGENIUS ACADEMY</span></br>
            <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
        </div>
        <!-- Welcome Message -->
        <div class="welcome-message" style="color: rgba(255, 193, 7, 0.8)">
            <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> (Teacher)</h1>
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
        <!-- Assignments Section -->
        <div class="assignments">
            <h2>Assignments</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Assignment ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Posted Date</th>
                        <th>Total Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to retrieve assignments taught by the teacher
                    $query = "SELECT * FROM assignments WHERE teacherID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['assignmentID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dueDate']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['postedDate']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['totalMarks']) . "</td>";
                            echo "<td>";
                            echo "<a href='updateAssignment.php?id=" . $row['assignmentID'] . "'>Update</a> | ";
                            echo "<a href='deleteAssignment.php?id=" . $row['assignmentID'] . "'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>There are no assignments at this time.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary"><a href="addAssignment.php">Add New Assignment</a></button>
        </div>
        <!-- Submissions Section -->
        <div class="submissions">
            <h2>Submissions</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Submission ID</th>
                        <th>Submission Date</th>
                        <th>File</th>
                        <th>Marks Obtained</th>
                        <th>Feedback</th>
                        <th>Assignment ID</th>
                        <th>Student ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch submissions data from the database
                    $query = "SELECT * FROM submissions WHERE assignmentID IN (SELECT assignmentID FROM assignments WHERE teacherID = ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Display each submission in a table row
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['submissionID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['submissionDate']) . "</td>";
                            echo "<td><a href='" . htmlspecialchars($row['filePath']) . "' target='_blank'>View File</a></td>";
                            echo "<td>" . htmlspecialchars($row['marksObtained']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['assignmentID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['studentID']) . "</td>";
                            echo "<td>";
                            echo "<a href='updateSubmission.php?submissionID=" . $row['submissionID'] . "'>Update</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>There are no submissions at this time.</td></tr>";
                    }

                    // Close the database connection
                    $conn->close();
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
