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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Retrieve the teacher ID from the GET parameter
    $teacherID = $_GET['teacherID'];

    // Validate the teacherID
    if (!isset($teacherID) || !is_numeric($teacherID)) {
        echo "Invalid teacher ID";
        exit;
    }

    // Retrieve the teacher details from the database
    $query = "SELECT * FROM teachers WHERE teacherID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $teacherID);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();

    if (!$teacher) {
        echo "Teacher not found";
        exit;
    }

    // Display a form to update the teacher details
    echo "<h2>Update Teacher</h2>";
    echo "<form action='updateTeacher.php' method='post'>";
    echo "<input type='hidden' name='teacherID' value='" . $teacherID . "'>";
    echo "<div class='form-group'>";
    echo "<label for='teacherName'>Teacher Name:</label>";
    echo "<input type='text' class='form-control' id='teacherName' name='teacherName' value='" . $teacher['teacherName'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='teacherSurname'>Teacher Surname:</label>";
    echo "<input type='text' class='form-control' id='teacherSurname' name='teacherSurname' value='" . $teacher['teacherSurname'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='email'>Email:</label>";
    echo "<input type='email' class='form-control' id='email' name='email' value='" . $teacher['email'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='password'>Password:</label>";
    echo "<input type='password' class='form-control' id='password' name='password' value='" . $teacher['password'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='hireDate'>Hire Date:</label>";
    echo "<input type='date' class='form-control' id='hireDate' name='hireDate' value='" . $teacher['hireDate'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='department'>Department:</label>";
    echo "<input type='text' class='form-control' id='department' name='department' value='" . $teacher['department'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='role'>Role:</label>";
    echo "<input type='text' class='form-control' id='role' name='role' value='" . $teacher['role'] . "' required>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Update Teacher</button>";
    echo "</form>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the teacher details if the form is submitted
    $teacher_name = $_POST['teacherName'];
    $teacher_surname = $_POST['teacherSurname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hire_date = $_POST['hireDate'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $teacherID = $_POST['teacherID'];

    $query = "UPDATE teachers SET teacherName = ?, teacherSurname = ?, email = ?, password = ?, hireDate = ?, department = ?, role = ? WHERE teacherID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssi", $teacher_name, $teacher_surname, $email, $password, $hire_date, $department, $role, $teacherID);
    $stmt->execute();

    echo "<p>Teacher updated successfully!</p>";
    header('Location: adminhome.php');
    exit;
}
?>