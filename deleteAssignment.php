<?php
// Define the database connection variables
$db_host = 'localhost'; // Replace with your database host
$db_username = 'root'; // Replace with your database username
$db_password = ''; // Replace with your database password
$db_name = 'tga'; // Replace with your database name

// Connect to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the assignment ID from the URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the assignment from the database
    $query = "DELETE FROM assignments WHERE assignmentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Assignment deleted successfully!');</script>";
        header("Location: teachershome.php");
        exit;
    } else {
        echo "Error deleting assignment: " . $conn->error;
    }
} else {
    echo "Assignment ID is not set or is empty.";
}

// Close the database connection
$conn->close();
?>