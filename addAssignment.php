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

// Connect to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the teacher's ID from the session
$teacher_id = $_SESSION['teacherID'];

// Check if the teacher ID is set and not empty
if (isset($teacher_id) && !empty($teacher_id)) {
    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseID = $_POST['courseID'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $dueDate = $_POST['dueDate'];
        $totalMarks = $_POST['totalMarks'];

        // Insert the assignment into the database
        $query = "INSERT INTO assignments (courseID, title, description, dueDate, totalMarks, teacherID) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssi", $courseID, $title, $description, $dueDate, $totalMarks, $teacher_id);
        $stmt->execute();

        // Check if the assignment was added successfully
        if ($stmt->affected_rows > 0) {
            echo "Assignment added successfully!";
            // Redirect to teachershome.php
            header('Location: teachershome.php');
            exit;
        } else {
            echo "Error adding assignment: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Teacher ID is not set or is empty.";
}

// Close the connection
$conn->close();
?>

<!-- HTML code starts here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <title>Add Assignment</title>
</head>
<body>
    <div class="container">
        <h2>Add Assignment</h2>
        <form method="post">
            <div class="form-group">
                <label for="courseID">Course ID:</label>
                <input type="text" class="form-control" id="courseID" name="courseID" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" required>
            </div>
            <div class="form-group">
                <label for="totalMarks">Total Marks:</label>
                <input type="number" class="form-control" id="totalMarks" name="totalMarks" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Assignment</button>
        </form>
    </div>
</body>
</html>