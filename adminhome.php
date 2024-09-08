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
    echo "Admin name: $admin_name<br>"; // Debug statement
} else {
    echo "Error: " . $conn->error; // Debug statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="adminhome.css">
    <title>Admin Home</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <!-- Sidebar navigational menu -->
                <div class="sidebar">
                    <div class="school-logo">
                        <img src="logo.png" alt="School Logo">
                    </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                            <a class="nav-link active" href="adminhome.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Teachers</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Students</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Courses</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="announcements.php">Announcements</a>
                            </li>
                        </ul>
                    <div class="logout-button">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="school-name">TECHGENIUS ACADEMY</div>
                <span style="font-size: 24px; color: rgba(0, 123, 255, 1); display: block; text-align: center; margin: 20px auto;">
                    Unlock Your Potential, Empower Your Future!
                </span>
                <!-- Header with welcome message -->
                <div class="header">
                    <h1>Welcome, <?php echo $admin_name; ?> (Admin)</h1>
                </div>
                <!-- Content area -->
                <div class="content">
                    <table class="table">
                    <h2 class='heading'>Teachers:</h2>
                        <tr>
                            <th>Teacher ID</th>
                            <th>Teacher Name</th>
                            <th>Teacher Surname</th>
                            <th>Email</th>
                            <th>Hire Date</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
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
                            echo "<a href='updateTeacher.php?teacherID=" . $row['teacherID'] . "'>Update</a> | ";
                            echo "<a href='deleteTeacher.php?teacherID=" . $row['teacherID'] . "'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <br>
                    <button type="button" class="btn btn-primary"><a href="addTeacher.php">Add New Teacher</a></button>
                </div></br></br>
                </br>
                <!-- Side-content area -->
                <div class="side-content">
                    <h5>Announcements:</h5>
                    <?php
                    // Query to retrieve all announcements
                    $query = "SELECT * FROM announcements ORDER BY postedDate DESC";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><a href='announcements.php'" . $row['announcementID'] . "'>" . $row['title'] . "</a></p>";
                        }
                    } else {
                        echo "<p>There are no announcements at this time.</p>";
                    }
                    ?>
                    <br>
                    <a href="addAnnouncement.php" class="btn btn-primary">Add Announcement</a>
                </div>
                <div class="content1">
                    <h2>Students:</h2>
                    <table>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
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
                            echo "<a href='fetchStudent.php?" . $row['studentID'] . "'>Update</a> | ";
                            echo "<a href='deleteStudent.php?id=" . $row['studentID'] . "'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <br>
                    <button type="button" class="btn btn-primary"><a href="addStudent.php">Add New Student</a></button>
                </div></br></br>
                <div class="content2">
                    <table>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Actions</th>
                        </tr>
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
                            echo "<a href='updateCourse.php?courseID=" . $row['courseID'] . "'>Update</a> | ";
                            echo "<a href='deleteCourse.php?courseID=" . $row['courseID'] . "'>Delete</a>";
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
                    </table>
                    <br>
                    <button type="button" class="btn btn-primary"><a href="addCourse.php">Add New Course</a></button>
                </div></br>
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
            </div>
        </div>
    </div>
</body>
</html>