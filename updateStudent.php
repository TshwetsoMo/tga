<?php
// Include the database connection file
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['studentID']) && !empty($_POST['studentID']) && filter_var($_POST['studentID'], FILTER_VALIDATE_INT)) {
        $studentID = $_POST['studentID'];
        $studentName = $_POST['studentName'];
        $studentSurname = $_POST['studentSurname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $enrollmentDate = $_POST['enrollmentDate'];
        $role = $_POST['role'];

        $query = "UPDATE students SET studentName = :studentName, studentSurname = :studentSurname, email = :email, password = :password, enrollmentDate = :enrollmentDate, role = :role WHERE studentID = :studentID";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':studentID', $studentID, PDO::PARAM_INT);
        $stmt->bindParam(':studentName', $studentName, PDO::PARAM_STR);
        $stmt->bindParam(':studentSurname', $studentSurname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':enrollmentDate', $enrollmentDate, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        echo "<script>alert('Student updated successfully!');</script>";
        header("Location: adminhome.php");
        exit;
    } else {
        echo "No student ID provided";
        exit;
    }
}
?>