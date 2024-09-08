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
$query = "SELECT studentName, studentID FROM students WHERE email = '" . $_SESSION['email'] . "'";
$result = $conn->query($query);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="studentshome.css">
    <title>Student Home</title>
    <style>
        .school-name {
            color: rgba(0, 123, 255, 1);
            text-align: center;
            font: 700 48px Orbitron, sans-serif;
            margin-bottom: 8px;
        }

        .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh; /* Make the sidebar full height */
        width: 210px; /* Adjust the width as needed */
        background-color: rgba(0, 105, 217, 1);
        padding: 20px;
        border-right: 3px solid rgba(255, 193, 7, 0.8);
        overflow-y: hidden; /* Make the sidebar non-scrollable */
    }
    .logout-button {
        position: absolute;
        bottom: 20px;
        left: 20px;
    }
    
    .logout-button a {
        color: rgb(255, 255, 255);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .logout-button a:hover {
        color: rgba(255, 193, 7, 0.8);
    }
    .content{
        width: 900px;
    }
    </style>
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
                            <a class="nav-link active" href="studentshome.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">My Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Assignments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="grades.php">My Grades</a>
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
                </span></br></br>
                <!-- Header with welcome message -->
                <div class="header">
                    <h1>Welcome, <?php echo $student_name; ?> (Student)</h1>
                </div>
                <<!-- Side-content area -->
                <div class="side-content">
                    <h5>Announcements:</h5>
                    <?php
                    // Query to retrieve all announcements
                    $query = "SELECT * FROM announcements ORDER BY postedDate DESC";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><a href='announcements.php?id=" . $row['announcementID'] . "'>" . $row['title'] . "</a></p>";
                        }
                    } else {
                        echo "<p>There are no announcements at this time.</p>";
                    }
                    ?>
                </div></br>
                
                <!-- Content area -->
                 <div class="content1" style='width: 700px'>
                    <h2>Uploaded Assignments</h2>
                    <?php
                    // Query to retrieve uploaded assignments for the current student
                    $studentID = $_SESSION['studentID']; // Define the $studentID variable
                    $query = "SELECT * FROM submissions WHERE studentID = '$studentID'";
                    $result = mysqli_query($conn, $query);

                    // Check if the deletion was successful
                    if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
                        echo "<p style='color: green;'>Assignment deleted successfully!</p>";
                    }

                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>";
                        echo "<tr><th>Submission Date</th><th>Assignment ID</th><th>File Name</th><th>Action</th></tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            $submissionID = $row['submissionID'];
                            $submissionDate = $row['submissionDate'];
                            $assignmentID = $row['assignmentID'];
                            $filePath = $row['filePath'];
                            $assignmentName = basename($filePath); // Get the file name from the path
                            echo "<tr>";
                            echo "<td>$submissionDate</td>";
                            echo "<td>$assignmentID</td>";
                            echo "<td><a href='$filePath' target='_blank'>$assignmentName</a></td>";
                            echo "<td><a href='deleteSubmission.php?submissionID=$submissionID'>Delete</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No uploaded assignments found.</p>";
                    }
                    ?>
                </div></br>
                <div class="content"  style='width: 900px'>
                    <!-- Add content here -->
                    <h2>My Assignments:</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Assignment ID</th>
                                <th>Assignment Title</th>
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
                                WHERE s.email = '" . $_SESSION['email'] . "'";
                        // echo "Query: " . $query . "<br>"; // Echo out the query
                        $result = $conn->query($query);
                        if (!$result) {
                            echo "Error: " . $conn->error . "<br>"; // Check for query execution errors
                        }
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['assignmentID'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['postedDate'] . "</td>";
                                echo "<td>" . $row['dueDate'] . "</td>";
                                echo "<td>" . $row['courseID'] . "</td>";
                                echo "<td><a href='addSubmission.php?id=<assignmentID>" . $row['assignmentID'] . "&studentID=" . $_SESSION['studentID'] . "' class='btn btn-primary'>Submit</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No assignments found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
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
            </div>
        </div>
    </div>
</body>
</html>