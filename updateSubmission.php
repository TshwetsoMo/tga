<?php
// Start the session
session_start();

// Include the database connection file
$conn = new mysqli("localhost", "root", "", "tga");

// Check if the user is logged in and has the teacher role
if (isset($_SESSION['teacherID']) && $_SESSION['teacherID'] > 0) {
    $teacherID = $_SESSION['teacherID'];
    $teacherEmail = $_SESSION['teacherEmail'];
    // Use the teacherID and teacherEmail to retrieve the teacher's information
} else {
    // Redirect to login page if teacherID is not set
    header('Location: login.php');
    exit;
}

// Initialize variables
$submission = null;
$submissionID = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['retrieve'])) {
        // Retrieve submission details
        $submissionID = $_POST['submissionID'];

        // Validate the submissionID
        if (!isset($submissionID) || !filter_var($submissionID, FILTER_VALIDATE_INT)) {
            $error = "Invalid submission ID";
        } else {
            // Retrieve the submission details from the database
            $query = "SELECT * FROM submissions WHERE submissionID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $submissionID);
            $stmt->execute();
            $result = $stmt->get_result();
            $submission = $result->fetch_assoc();

            if (!$submission) {
                $error = "Submission not found";
            }
        }
    } elseif (isset($_POST['update'])) {
        // Update submission details
        $submissionID = $_POST['submissionID'];
        $marksObtained = $_POST['marksObtained'];
        $feedback = $_POST['feedback'];

        // Validate inputs
        if (!isset($submissionID) || !filter_var($submissionID, FILTER_VALIDATE_INT)) {
            $error = "Invalid submission ID";
        } else {
            $query = "UPDATE submissions SET marksObtained = ?, feedback = ? WHERE submissionID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("dsi", $marksObtained, $feedback, $submissionID);
            $stmt->execute();

            $success = "Submission updated successfully!";
            header('Location: teachershome.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Submission - TechGenius Academy</title>
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
            background-image: url('https://wallpapercave.com/wp/wp4667097.jpg');
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
        /* Sidebar Styles */
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
        /* Main Content Styles */
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
            color: rgba(255, 193, 7, 0.8);
        }
        .page-title h1 {
            font-family: 'Orbitron', sans-serif;
        }
        /* Form Styles */
        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group label {
            font-weight: bold;
            color: #0069d9;
        }
        .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            margin-top: 20px;
        }
        .btn-primary:hover {
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
            margin-top: 20px;
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
        /* Table Styles */
        .table {
            background-color: #fff;
        }
        .table th {
            background-color: #0069d9;
            color: #fff;
        }
        .alert {
            max-width: 800px;
            margin: 0 auto 20px;
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
            <li class="nav-item">
                <a class="nav-link" href="viewAssignments.php"><i class="fas fa-tasks"></i> View Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="updateSubmission.php"><i class="fas fa-edit"></i> Update Submission</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="viewCourses.php"><i class="fas fa-book"></i> View Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="teacherAnnouncements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <!-- Sidebar End -->

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Banner -->
        <div class="header-banner">
            <span class="title">TECHGENIUS ACADEMY</span><br>
            <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
        </div>
        <!-- Page Title -->
        <div class="page-title">
            <h1>Update Submission</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Form Container -->
        <div class="form-container">
            <?php if (!$submission): ?>
                <!-- Retrieve Submission Form -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="submissionID">Submission ID:</label>
                        <input type="number" id="submissionID" name="submissionID" class="form-control" required>
                    </div>
                    <button type="submit" name="retrieve" class="btn btn-primary">Retrieve Submission</button>
                </form>
            <?php else: ?>
                <!-- Display Submission Details -->
                <table class="table table-bordered">
                    <tr>
                        <th>Submission ID</th>
                        <td><?php echo htmlspecialchars($submission['submissionID']); ?></td>
                    </tr>
                    <tr>
                        <th>Submission Date</th>
                        <td><?php echo htmlspecialchars($submission['submissionDate']); ?></td>
                    </tr>
                    <tr>
                        <th>File Path</th>
                        <td><?php echo htmlspecialchars($submission['filePath']); ?></td>
                    </tr>
                    <tr>
                        <th>Assignment ID</th>
                        <td><?php echo htmlspecialchars($submission['assignmentID']); ?></td>
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <td><?php echo htmlspecialchars($submission['studentID']); ?></td>
                    </tr>
                    <tr>
                        <th>Marks Obtained</th>
                        <td><?php echo htmlspecialchars($submission['marksObtained']); ?></td>
                    </tr>
                    <tr>
                        <th>Feedback</th>
                        <td><?php echo htmlspecialchars($submission['feedback']); ?></td>
                    </tr>
                </table>
                <!-- Update Submission Form -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="hidden" name="submissionID" value="<?php echo htmlspecialchars($submissionID); ?>">
                    <div class="form-group">
                        <label for="marksObtained">Marks Obtained:</label>
                        <input type="number" id="marksObtained" name="marksObtained" class="form-control" value="<?php echo htmlspecialchars($submission['marksObtained']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea id="feedback" name="feedback" class="form-control" rows="5" required><?php echo htmlspecialchars($submission['feedback']); ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update Submission</button>
                </form>
            <?php endif; ?>
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
