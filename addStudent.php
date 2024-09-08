<?php
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
<!-- Content area -->
<div class="content">
    <!-- Add content here -->
    <h5>Add New Student:</h5>
    <form action="addStudent.php" method="post">
        <label for="studentID">Student ID:</label>
        <input type="text" id="studentID" name="studentID"><br><br>
        <label for="studentName">Name:</label>
        <input type="text" id="studentName" name="studentName"><br><br>
        <label for="studentSurname">Surname:</label>
        <input type="text" id="studentSurname" name="studentSurname"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password"><br><br>
        <label for="enrollmentDate">Enrollment Date:</label>
        <input type="text" id="enrollmentDate" name="enrollmentDate"><br><br>
        <label for="role">Role:</label>
        <input type="text" id="role" name="role"><br><br>

        <input type="submit" value="Add Student">
    </form>
</div>