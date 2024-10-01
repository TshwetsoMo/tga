<?php
// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

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

// Get the admin's name from the database
$query = "SELECT adminName FROM admin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $admin_name = $row['adminName'];
} else {
    // Handle error
    $admin_name = "Admin";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home - TechGenius Academy</title>
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
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
            color: rgba(255, 193, 7, 0.8);
        }
        .welcome-message h1 {
            font-family: 'Orbitron', sans-serif;
        }
        /* Cards */
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .card-header h2 {
            font-family: 'Orbitron', sans-serif;
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
        .btn-primary, .btn-warning, .btn-danger {
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
        }
        .btn-primary {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #e0a800;
            color: #000;
        }
        .btn-warning {
            background-color: #fd7e14;
            color: #fff;
        }
        .btn-warning:hover {
            background-color: #e66900;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #c82333;
            color: #fff;
        }
        .btn a {
            color: inherit;
            text-decoration: none;
        }
        .btn a:hover {
            color: inherit;
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
                <a class="nav-link active" href="adminhome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageTeachers.php"><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageStudents.php"><i class="fas fa-user-graduate"></i> Manage Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageCourses.php"><i class="fas fa-book"></i> Manage Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
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
        <!-- Welcome Message -->
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?> (Admin)</h1>
        </div>
        <!-- Teachers Section -->
        <div class="card">
            <div class="card-header">
                <h2>Teachers</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Teacher ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Hire Date</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to retrieve all teachers
                        $query = "SELECT * FROM teachers";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["teacherID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["teacherName"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["teacherSurname"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["hireDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["department"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                            echo "<td>";
                            echo "<a href='updateTeacher.php?teacherID=" . $row['teacherID'] . "' class='btn btn-sm btn-warning'>Update</a> ";
                            echo "<a href='deleteTeacher.php?teacherID=" . $row['teacherID'] . "' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="addTeacher.php" class="btn btn-primary mt-3">Add New Teacher</a>
            </div>
        </div>
        <!-- Students Section -->
        <div class="card">
            <div class="card-header">
                <h2>Students</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Enrollment Date</th>
                            <th>Major</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to retrieve all students
                        $query = "SELECT * FROM students";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['studentID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['studentName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['studentSurname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['enrollmentDate']) . "</td>";
                            echo "<td>";
                            echo "<a href='updateStudent.php?studentID=" . $row['studentID'] . "' class='btn btn-sm btn-warning'>Update</a> ";
                            echo "<a href='deleteStudent.php?studentID=" . $row['studentID'] . "' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="addStudent.php" class="btn btn-primary mt-3">Add New Student</a>
            </div>
        </div>
        <!-- Courses Section -->
        <div class="card">
            <div class="card-header">
                <h2>Courses</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Credits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to retrieve all courses
                        $query = "SELECT * FROM courses";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['courseID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['courseName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['courseCode']) . "</td>";
                            echo "<td>";
                            echo "<a href='updateCourse.php?courseID=" . $row['courseID'] . "' class='btn btn-sm btn-warning'>Update</a> ";
                            echo "<a href='deleteCourse.php?courseID=" . $row['courseID'] . "' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        if (isset($_GET['message'])) {
                            $message = $_GET['message'];
                            ?>
                            <script>
                                alert("<?php echo htmlspecialchars($message); ?>");
                            </script>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="addCourse.php" class="btn btn-primary mt-3">Add New Course</a>
            </div>
        </div>
        <!-- Announcements Section -->
        <div class="card">
            <div class="card-header">
                <h2>Announcements</h2>
            </div>
            <div class="card-body">
                <?php
                // Query to retrieve all announcements
                $query = "SELECT * FROM announcements ORDER BY postedDate DESC";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<p><strong>" . htmlspecialchars($row['title']) . "</strong><br>";
                        echo htmlspecialchars($row['description']) . "<br>";
                        echo "<small>Posted on: " . htmlspecialchars($row['postedDate']) . "</small></p><hr>";
                    }
                } else {
                    echo "<p>There are no announcements at this time.</p>";
                }
                ?>
                <a href="addAnnouncement.php" class="btn btn-primary mt-3">Add Announcement</a>
            </div>
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

