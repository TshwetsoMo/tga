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
$query = "SELECT adminName FROM admin WHERE email = '" . $_SESSION['email'] . "'";
$result = $conn->query($query);
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

        /* Custom CSS */
        body {
            background-color: #f2f2f2;
            font-family: 'Roboto', sans-serif;
        }
        .header{
            color: #ffc107;
        }
        .school-name {
            color: #007bff;
            text-align: center;
            font: 700 48px 'Orbitron', sans-serif;
            margin-top: 20px;
        }
        .subtitle {
            font-size: 24px;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
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
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header h2 {
            margin: 0;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-sm {
            margin-right: 5px;
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
                <a class="nav-link" href="#"><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user-graduate"></i> Manage Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-book"></i> Manage Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="school-name">TECHGENIUS ACADEMY</div>
        <div class="subtitle">Unlock Your Potential, Empower Your Future!</div>
        <!-- Header with welcome message -->
        <div class="header">
            <h1>Welcome, <?php echo $admin_name; ?> (Admin)</h1>
        </div>
        <!-- Teachers Section -->
        <div class="card">
            <div class="card-header">
                <h2>Teachers</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
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
                            echo "<td>" . $row["teacherID"] . "</td>";
                            echo "<td>" . $row["teacherName"] . "</td>";
                            echo "<td>" . $row["teacherSurname"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["hireDate"] . "</td>";
                            echo "<td>" . $row["department"] . "</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td>";
                            echo "<a href='updateTeacher.php?teacherID=" . $row['teacherID'] . "' class='btn btn-sm btn-warning'>Update</a>";
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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
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
                            echo "<td>" . $row['studentID'] . "</td>";
                            echo "<td>" . $row['studentName'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>";
                            echo "<a href='updateStudent.php?studentID=" . $row['studentID'] . "' class='btn btn-sm btn-warning'>Update</a>";
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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Name</th>
                            <th>Code</th>
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
                            echo "<td>" . $row['courseID'] . "</td>";
                            echo "<td>" . $row['courseName'] . "</td>";
                            echo "<td>" . $row['courseCode'] . "</td>";
                            echo "<td>";
                            echo "<a href='updateCourse.php?courseID=" . $row['courseID'] . "' class='btn btn-sm btn-warning'>Update</a>";
                            echo "<a href='deleteCourse.php?courseID=" . $row['courseID'] . "' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        if (isset($_GET['message'])) {
                            $message = $_GET['message'];
                            ?>
                            <script>
                                alert("<?php echo $message; ?>");
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
                        echo "<p><strong>" . $row['title'] . "</strong><br>";
                        echo $row['description'] . "<br>";
                        echo "<small>Posted on: " . $row['postedDate'] . "</small></p><hr>";
                    }
                } else {
                    echo "<p>There are no announcements at this time.</p>";
                }
                ?>
                <a href="addAnnouncement.php" class="btn btn-primary mt-3">Add Announcement</a>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer style="width: 1050px; float: right; margin-right:20px; ">
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
