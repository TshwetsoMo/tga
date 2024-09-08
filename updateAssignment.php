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
    // Get the assignment ID from the URL parameter
    $assignment_id = $_GET['id'];

    // Check if the assignment ID is set and not empty
    if (isset($assignment_id) && !empty($assignment_id)) {
        // Process the form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $courseID = $_POST['courseID'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['dueDate'];
            $totalMarks = $_POST['totalMarks'];

            // Update the assignment in the database
            $query = "UPDATE assignments SET courseID = ?, title = ?, description = ?, dueDate = ?, totalMarks = ? WHERE assignmentID = ? AND teacherID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issssii", $courseID, $title, $description, $dueDate, $totalMarks, $assignment_id, $teacher_id);
            $stmt->execute();

            // Check if the assignment was updated successfully
            if ($stmt->affected_rows > 0) {
                echo "Assignment updated successfully!";
                // Redirect to teachershome.php
                header('Location: teachershome.php');
                exit;
            } else {
                echo "Error updating assignment: " . $conn->error;
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else {
            // Retrieve the assignment details from the database
            $query = "SELECT * FROM assignments WHERE assignmentID = ? AND teacherID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $assignment_id, $teacher_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $assignment = $result->fetch_assoc();

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Assignment ID is not set or is empty.";
    }
} else {
    echo "Teacher ID is not set or is empty.";
}
?>

<!-- HTML code starts here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <title>Update Assignment</title>
</head>
<body>
    <div class="container">
        <h2>Update Assignment</h2>
        <?php if (isset($assignment)): ?>
        <form method="post">
            <div class="form-group">
                <label for="courseID">Course ID:</label>
                <input type="text" class="form-control" id="courseID" name="courseID" value="<?php echo $assignment['courseID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $assignment['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $assignment['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" value="<?php echo $assignment['dueDate']; ?>" required>
            </div>
            <div class="form-group">
                <label for="totalMarks">Total Marks:</label>
                <input type="number" class="form-control" id="totalMarks" name="totalMarks" value="<?php echo $assignment['totalMarks']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Assignment</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>