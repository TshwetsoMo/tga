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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add the course to the database
    $course_name = $_POST['courseName'];
    $course_code = $_POST['courseCode'];
    $credits = $_POST['credits'];
    $department = $_POST['department'];
    $teacherID = $_POST['teacherID'];

    $query = "INSERT INTO courses (courseName, courseCode, credits, department, teacherID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisi", $course_name, $course_code, $credits, $department, $teacherID);
    $stmt->execute();

    // Redirect to admin home after successful addition
    header('Location: adminhome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course - TechGenius Academy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #0069d9;
            background-image: url('your-background-image.jpg'); /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: 'Roboto', sans-serif;
            color: #fff;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Orbitron', sans-serif;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            color: #000;
        }
        .form-control:focus {
            box-shadow: none;
            background-color: #fff;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        .btn-submit {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px 20px;
            width: 100%;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background-color: #e0a800;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Course</h2>
        <form action="addCourse.php" method="post">
            <label for="courseName">Course Name:</label>
            <input type="text" class="form-control" id="courseName" name="courseName" required>

            <label for="courseCode">Course Code:</label>
            <input type="text" class="form-control" id="courseCode" name="courseCode" required>

            <label for="credits">Credits:</label>
            <input type="number" class="form-control" id="credits" name="credits" required>

            <label for="department">Department:</label>
            <input type="text" class="form-control" id="department" name="department" required>

            <label for="teacherID">Teacher ID:</label>
            <input type="number" class="form-control" id="teacherID" name="teacherID" required>

            <button type="submit" class="btn btn-submit">Add Course</button>
        </form>
        <div class="back-link">
            <a href="adminhome.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
