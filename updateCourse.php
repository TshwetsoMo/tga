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

// Check if the courseID parameter is set
if (isset($_GET['courseID']) && !empty($_GET['courseID'])) {
    $courseID = $_GET['courseID'];

    // Display a form to enter the teacher's ID
    echo "<form action='updateCourse.php' method='post'>";
    echo "Enter Teacher's ID: <input type='text' name='teacherID'><br>";
    echo "<input type='hidden' name='courseID' value='$courseID'>";
    echo "<input type='submit' value='Update Course'>";
    echo "</form>";

    // Check if the form has been submitted
    if (isset($_POST['teacherID']) && !empty($_POST['teacherID'])) {
        $teacherID = $_POST['teacherID'];
        $courseID = $_POST['courseID'];

        // Check if the course exists
        $courseStmt = $mysqli->prepare("SELECT * FROM courses WHERE courseID = ?");
        $courseStmt->bind_param("i", $courseID);
        $courseStmt->execute();
        $courseResult = $courseStmt->get_result();

        if ($courseResult->num_rows > 0) {
            // Course exists, proceed with update
            // Check if the teacherID exists in the teachers table
            $teacherStmt = $mysqli->prepare("SELECT * FROM teachers WHERE teacherID = ?");
            $teacherStmt->bind_param("i", $teacherID);
            $teacherStmt->execute();
            $teacherResult = $teacherStmt->get_result();

            if ($teacherResult->num_rows > 0) {
                // TeacherID exists, proceed with update
                $updateStmt = $mysqli->prepare("UPDATE courses SET teacherID = ? WHERE courseID = ?");
                $updateStmt->bind_param("ii", $teacherID, $courseID);
                $updateStmt->execute();

                echo "Course with ID $courseID has been updated successfully.";
            } else {
                // TeacherID doesn't exist, handle the error
                echo "Error: Teacher with ID $teacherID does not exist.";
            }
        } else {
            // Course doesn't exist, handle the error
            echo "Error: Course with ID $courseID does not exist.";
        }
    }
} else {
    echo "Error: Course ID is required.";
    exit;
}

// Close connection
$mysqli->close();
?>