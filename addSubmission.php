<?php
// Check if the user is logged in and has the student role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'students') {
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

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignmentID = $_POST['assignmentID'];
    $filePath = $_FILES['file']['name'];
    $tmpFilePath = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    // Check if the file is valid
    if ($fileSize > 0 && $fileType == 'application/pdf') {
        $uploadDir = 'uploads/';
        $fileDestination = $uploadDir . $filePath;

        // Check if the file upload was successful
        if (move_uploaded_file($tmpFilePath, $fileDestination)) {
            // File upload successful, proceed with database insertion
            // Insert submission into the database
            $query = "INSERT INTO submissions (submissionDate, filePath, marksObtained, feedback, assignmentID, studentID) 
                    VALUES (NOW(), ?, 0, '', ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $filePath, $assignmentID, $_SESSION['studentID']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Submission successful!";
                header('Location: studentshome.php');
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error: File upload failed.";
        }
    } else {
        echo "Error: Invalid file format or size.";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- HTML form to upload the file -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label>Assignment ID:</label>
        <input type="number" name="assignmentID" required>
        <label>Upload date:</label>
        <input type="date" name="date" required>
        <label>Upload your assignment</label>
        <input type="file" name="file" required>
        <button type="submit">Submit Assignment</button>
    </form>
</body>
</html>
