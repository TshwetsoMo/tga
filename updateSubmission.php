<?php
// updateSubmission.php
// Start the session
session_start();

// Include the database connection file
require_once 'db.php';

// Check if the user is logged in and has the teacher role
if (isset($_SESSION['teacherID']) && $_SESSION['teacherID'] > 0) {
    $teacherID = $_SESSION['teacherID'];
    $teacherEmail = $_SESSION['teacherEmail'];
    // Use the teacherID and teacherEmail to retrieve the teacher's information
} else {
    // Redirect to login page if teacherID is not set
    header('Location: login.php');
    exit;
}

// Display a form to input the submission ID
echo "<h1>Update Submission</h1>";
echo "<form action='updateSubmission.php' method='post'>";
echo "<label for='submissionID'>Submission ID:</label>";
echo "<input type='number' id='submissionID' name='submissionID'>";
echo "<br>";
echo "<input type='submit' value='Retrieve Submission'>";
echo "</form>";

// Retrieve the submission details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submissionID = $_POST['submissionID'];

    // Validate the submissionID
    if (!isset($submissionID) || !is_numeric($submissionID)) {
        echo "Invalid submission ID";
        exit;
    }

    // Retrieve the submission details from the database
    $query = "SELECT * FROM submissions WHERE submissionID = :submissionID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':submissionID', $submissionID);
    $stmt->execute();
    $submission = $stmt->fetch();

    if ($submission) {
        // Display the submission details
        echo "<h1>Update Submission</h1>";
        echo "<p>Submission ID: " . $submission['submissionID'] . "</p>";
        echo "<p>Submission Date: " . $submission['submissionDate'] . "</p>";
        echo "<p>File Path: " . $submission['filePath'] . "</p>";
        echo "<p>Assignment ID: " . $submission['assignmentID'] . "</p>";
        echo "<p>Student ID: " . $submission['studentID'] . "</p>";
        echo "<p>Marks Obtained: " . $submission['marksObtained'] . "</p>";
        echo "<p>Feedback: " . $submission['feedback'] . "</p>";

        // Display a form to update the marks and feedback
        echo "<form action='updateSubmission.php' method='post'>";
        echo "<label for='marksObtained'>Marks Obtained:</label>";
        echo "<input type='number' id='marksObtained' name='marksObtained' value='" . $submission['marksObtained'] . "'>";
        echo "<br>";
        echo "<label for='feedback'>Feedback:</label>";
        echo "<textarea id='feedback' name='feedback'>" . $submission['feedback'] . "</textarea>";
        echo "<br>";
        echo "<input type='hidden' name='submissionID' value='" . $submissionID . "'>";
        echo "<input type='submit' value='Update Submission'>";
        echo "</form>";
    } else {
        echo "Submission not found";
        exit;
    }
}

// Update the submission details if the form is submitted again
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marksObtained']) && isset($_POST['feedback'])) {
    $marksObtained = $_POST['marksObtained'];
    $feedback = $_POST['feedback'];
    $submissionID = $_POST['submissionID'];

    // Validate the submissionID
    if (!isset($submissionID) || !is_numeric($submissionID)) {
        echo "Invalid submission ID";
        exit;
    }

    $query = "UPDATE submissions SET marksObtained = :marksObtained, feedback = :feedback WHERE submissionID = :submissionID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':marksObtained', $marksObtained);
    $stmt->bindParam(':feedback', $feedback);
    $stmt->bindParam(':submissionID', $submissionID);
    $stmt->execute();

    echo "<p>Submission updated successfully!</p>";

    // Debug statement: Check the session data before redirect
    var_dump($_SESSION);

    session_write_close();
    header('Location: teachershome.php');
    exit;
}
?>