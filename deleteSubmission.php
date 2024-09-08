<?php
// Define database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tga";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the submission ID is set
if (isset($_GET['submissionID'])) {
    $submissionID = $_GET['submissionID'];

    // Query to delete the submission
    $query = "DELETE FROM submissions WHERE submissionID = '$submissionID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Display a success message
        $successMessage = "Assignment deleted successfully!";
        echo "<p style='color: green;'>$successMessage</p>";
        // Redirect back to studentshome.php
        header('Location: studentshome.php?deleted=true');
        exit;
    } else {
        echo "<p style='color: red;'>Error deleting assignment: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>No submission ID provided.</p>";
}

// Close connection
$conn->close();
?>