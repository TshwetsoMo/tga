<?php
// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "tga");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Delete course enrollments associated with the student
$stmt = $conn->prepare("DELETE FROM courseenrollment WHERE studentID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Delete the student
$stmt = $conn->prepare("DELETE FROM students WHERE studentID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Confirmation message
echo "<script>alert('Student with ID $id has been successfully deleted!');</script>";

header("Location: studentshome.php");
exit;
?>