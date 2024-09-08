<?php
// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Create a connection to the database
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'tga';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new announcement
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $role = $_SESSION['role'];

    // Check if adminID is set in the session
    if (isset($_SESSION['adminID'])) {
        $postedBy = $_SESSION['adminID'];
    } else {
        // If adminID is not set, display an error message
        echo "Error: adminID is not set in the session.";
        exit;
    }

    $query = "INSERT INTO announcements (title, description, postedDate, postedBy, role) VALUES (?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $title, $description, $postedBy, $role);
    $stmt->execute();

    if ($stmt) {
        header('Location: adminhome.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <title>Add Announcement</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Add Announcement</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                        <div class="form-group">
                        <label for="title">Date:</label>
                        <input type="date" class="form-control" id="postedDate" name="postedDate" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Add Announcement</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>