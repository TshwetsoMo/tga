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

// // Check if the teacher exists
// $teacherStmt = $mysqli->prepare("SELECT * FROM teachers WHERE teacherID = ?");
// $teacherStmt->bind_param("i", $teacherID);
// $teacherStmt->execute();
// $teacherResult = $teacherStmt->get_result();

// if ($teacherResult->num_rows > 0) {
//     // Teacher exists, proceed with inserting the course
//     $stmt->execute();
// } else {
//     // Teacher doesn't exist, handle the error
//     echo "Error: Teacher with ID $teacherID does not exist.";
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add the course to the database
    $course_name = $_POST['courseName'];
    $course_code = $_POST['courseCode'];
    $credits = $_POST['credits'];
    $department = $_POST['department'];
    $teacherID = $_POST['teacherID'];

    $query = "INSERT INTO courses (courseName, courseCode, credits, department, teacherID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siisi", $course_name, $course_code, $credits, $department, $teacherID);
    $stmt->execute();

    echo "<p>Course added successfully!</p>";
    header('Location: adminhome.php');
    exit;
}

// Display the form to add a course
echo "<h2>Add Course</h2>";
echo "<form action='addCourse.php' method='post'>";
echo "<div class='form-group'>";
echo "<label for='courseName'>Course Name:</label>";
echo "<input type='text' class='form-control' id='courseName' name='courseName' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='courseCode'>Course Code:</label>";
echo "<input type='number' class='form-control' id='courseCode' name='courseCode' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='credits'>Credits:</label>";
echo "<input type='number' class='form-control' id='credits' name='credits' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='department'>Department:</label>";
echo "<input type='text' class='form-control' id='department' name='department' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='teacherID'>Teacher ID:</label>";
echo "<input type='number' class='form-control' id='teacherID' name='teacherID' required>";
echo "</div>";
echo "<button type='submit' class='btn btn-primary'>Add Course</button>";
echo "</form>";
?>