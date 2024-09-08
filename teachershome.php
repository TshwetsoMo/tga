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

// Get the teacher's name and ID from the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
$query = "SELECT teacherName, teacherID FROM teachers WHERE email = '" . $_SESSION['email'] . "'";
$result = $conn->query($query);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <title>Teacher Home</title>
    <style>
        body {
            background-color: rgba(202, 223, 244, 1);
        }
        .school-name {
            color: rgba(0, 123, 255, 1);
            text-align: center;
            font: 700 48px Orbitron, sans-serif;
            margin-bottom: 8px;
        }
        .header{
            color:rgb(255, 193, 7)
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
        
        .sidebar ul {
            padding-bottom: 50px; /* Add some space at the bottom for the logout button */
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

        .school-logo {
        margin-bottom: 20px;
        }

        .school-logo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid rgb(250, 250, 250);
        }
            /* Navigation Styles */

        .nav {
        list-style: none;
        padding: 0;
        margin: 0;
        }

        .nav-item {
        margin-bottom: 10px;
        border-bottom: #ddd 1px solid;
        }

        .nav-item:hover {
        color: rgba(255, 193, 7, 0.8);
        }

        .nav-link {
        color: rgb(255, 255, 255);
        text-decoration: none;
        transition: color 0.2s ease;
        }

        .nav-link:hover {
        color: rgba(255, 193, 7, 0.8);
        }

        .nav-link.active {
        color: rgba(255, 193, 7, 0.8);
        font-weight: bold;
        }

        .nav-link.active::before {
        content: "";
        display: block;
        width: 5px;
        height: 100%;
        background-color: rgba(255, 193, 7, 0.8);
        position: absolute;
        left: -20px;
        top: 0;
        }
        .side-content {
            float: right;
            width: 27%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            justify-self: flex-end;
            margin-bottom: 10px;
        }

        .side-content h5 {
            margin-top: 0;
        }

        .side-content p {
            margin-bottom: 10px;
        }

        .side-content a {
            text-decoration: none;
            color: #337ab7;
        }

        .side-content a:hover {
            color: #23527c;
        }
        .content {
        max-width: 800px;
        padding: 10px;
        background-color: rgba(0, 105, 217, 1);
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
        margin-top: 0;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        }

        th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        }

        th {
        background-color: #f0f0f0;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        tr:hover {
        background-color: #e9e9e9;
        }

        .actions {
        text-align: center;
        }

        .actions a {
        margin: 0 10px;
        color: #337ab7;
        text-decoration: none;
        }

        .actions a:hover {
        color: #23527c;
        }

        .btn-primary {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #337ab7;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }

        .btn-primary:hover {
        background-color: #23527c;
        }

        .btn-primary a {
        color: #fff;
        text-decoration: none;
        }

        .btn-primary a:hover {
        color: #fff;
        }
        .content1 {
        max-width: 100%px;
        padding: 10px;
        background-color: rgba(0, 105, 217, 1);
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        margin-top: 10px;
        }

        h2 {
        margin-top: 0;
        }

        .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        }

        .table-bordered {
        border: 1px solid #ddd;
        }

        th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        }

        th {
        background-color: #6b6b6b;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        tr:hover {
        background-color: #e9e9e9;
        }

        tbody tr:last-child {
        border-bottom: none;
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
                            <a class="nav-link active" href="teachershome.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">My Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Assignments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gradebook</a>
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
                    <h1>Welcome, <?php echo $teacher_name; ?> (Teacher)</h1>
                </div>
                <!-- Content area -->
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
                </div>
                <div class="content">
                    <!-- Add content here -->
                    <h2>Assignments:</h2>
                    <table class="table">
                        <tr>
                            <th>Assignment ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Posted Date</th>
                            <th>Total Marks</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        // Query to retrieve assignments taught by the teacher
                        $query = "SELECT * FROM assignments WHERE teacherID = '" . $teacher_id . "'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['assignmentID'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['dueDate'] . "</td>";
                                echo "<td>" . $row['postedDate'] . "</td>";
                                echo "<td>" . $row['totalMarks'] . "</td>";
                                echo "<td>";
                                echo "<a href='updateAssignment.php?id=" . $row['assignmentID'] . "'>Update</a> | ";
                                echo "<a href='deleteAssignment.php?id=" . $row['assignmentID'] . "'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>There are no assignments at this time.</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </table>
                    <br>
                    <button type="button" class="btn btn-primary"><a href="addAssignment.php">Add New Assignment</a></button>
                </div></br></br>
                <!-- next section -->
                <div class="content1">
                    <h2>Submissions</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Submission ID</th>
                                <th>Submission Date</th>
                                <th>File Path</th>
                                <th>Marks Obtained</th>
                                <th>Feedback</th>
                                <th>Assignment ID</th>
                                <th>Student ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connect to the database
                            $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

                            // Fetch submissions data from the database
                            $query = "SELECT * FROM submissions";
                            $result = $conn->query($query);

                            // Display each submission in a table row
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['submissionID'] . "</td>";
                                    echo "<td>" . $row['submissionDate'] . "</td>";
                                    echo "<td>" . $row['filePath'] . "</td>";
                                    echo "<td>" . $row['marksObtained'] . "</td>";
                                    echo "<td>" . $row['feedback'] . "</td>";
                                    echo "<td>" . $row['assignmentID'] . "</td>";
                                    echo "<td>" . $row['studentID'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='updateSubmission.php?submissionID=" . $row['submissionID'] . "'>Update</a> | ";
                                    echo "<td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>There are no submissions at this time.</td></tr>";
                            }

                            // Close the database connection
                            $conn->close();
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