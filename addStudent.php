<?php
// Check if the user is logged in and has the admin role (optional, add if needed)
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "tga");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST['studentID'];
    $studentName = $_POST['studentName'];
    $studentSurname = $_POST['studentSurname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $enrollmentDate = $_POST['enrollmentDate'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO students (studentID, studentName, studentSurname, email, password, enrollmentDate, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $studentID, $studentName, $studentSurname, $email, $password, $enrollmentDate, $role);
    $stmt->execute();

    // Success message
    echo "<script>alert('New student added successfully!');</script>";

    header("Location: studentshome.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student - TechGenius Academy</title>
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
        <h2>Add New Student</h2>
        <form action="addStudent.php" method="post">
            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" name="studentID" class="form-control" required>

            <label for="studentName">Name:</label>
            <input type="text" id="studentName" name="studentName" class="form-control" required>

            <label for="studentSurname">Surname:</label>
            <input type="text" id="studentSurname" name="studentSurname" class="form-control" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <label for="enrollmentDate">Enrollment Date:</label>
            <input type="date" id="enrollmentDate" name="enrollmentDate" class="form-control" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" class="form-control" required>

            <button type="submit" class="btn btn-submit">Add Student</button>
        </form>
        <div class="back-link">
            <a href="adminhome.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
