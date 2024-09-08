<?php
// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tga";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the course ID to delete
$courseID = $_GET['courseID'];

// Check if the course exists
$courseStmt = $mysqli->prepare("SELECT * FROM courses WHERE courseID = ?");
$courseStmt->bind_param("i", $courseID);
$courseStmt->execute();
$courseResult = $courseStmt->get_result();

if ($courseResult->num_rows > 0) {
    // Course exists, proceed with deletion
    $deleteStmt = $mysqli->prepare("DELETE FROM courses WHERE courseID = ?");
    $deleteStmt->bind_param("i", $courseID);
    $deleteStmt->execute();

    // Redirect to adminhome.php with success message
    $message = "Course with ID $courseID has been deleted successfully.";
    header("Location: adminhome.php?message=$message");
    exit;
} else {
    // Course doesn't exist, handle the error
    $message = "Error: Course with ID $courseID does not exist.";
    header("Location: adminhome.php?message=$message");
    exit;
}

// Close connection
$mysqli->close();
?>