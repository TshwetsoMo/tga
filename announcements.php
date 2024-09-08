<!-- announcements.php -->
<?php
// config.php
// Database connection settings
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'tga';

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Retrieve the admin's name from the database
$stmt = $conn->prepare("SELECT adminName FROM admin WHERE adminID = ?");
$stmt->bind_param("i", $_SESSION['adminID']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$adminName = $admin['adminName'];

// Retrieve the announcement data from the database
$query = "SELECT * FROM announcements";
$result = $conn->query($query);
$announcements = array();
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}
// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Insert announcement into database
    $query = "INSERT INTO announcements (title, description, postedDate) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();

    // Redirect to same page to display new announcement
    header('Location: announcements.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Announcements</title>
    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh; /* Make the sidebar full height */
            width: 210px; /* Adjust the width as needed */
            background-color: rgba(0, 105, 217, 1);
            padding: 20px;
            border-right: 3px solid rgba(255, 193, 7, 0.8);
            overflow-y: hidden; /* Make the sidebar non-scrollable */
        }
        
        .sidebar ul {
            padding-bottom: 50px; /* Add some space at the bottom for the logout button */
        }
        
        .logout-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        
        .logout-button a {
            color: rgb(255, 255, 255);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .logout-button a:hover {
            color: rgba(255, 193, 7, 0.8);
        }

        .school-logo {
        margin-bottom: 20px;
        }

        .school-logo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid rgb(250, 250, 250);
        }
            /* Navigation Styles */

        .nav {
        list-style: none;
        padding: 0;
        margin: 0;
        }

        .nav-item {
        margin-bottom: 10px;
        border-bottom: #ddd 1px solid;
        }

        .nav-item:hover {
        color: rgba(255, 193, 7, 0.8);
        }

        .nav-link {
        color: rgb(255, 255, 255);
        text-decoration: none;
        transition: color 0.2s ease;
        }

        .nav-link:hover {
        color: rgba(255, 193, 7, 0.8);
        }

        .nav-link.active {
        color: rgba(255, 193, 7, 0.8);
        font-weight: bold;
        }

        .nav-link.active::before {
        content: "";
        display: block;
        width: 5px;
        height: 100%;
        background-color: rgba(255, 193, 7, 0.8);
        position: absolute;
        left: -20px;
        top: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar">
                    <div class="school-logo">
                        <img src="logo.png" alt="School Logo">
                    </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                            <a class="nav-link active" href="adminhome.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Teachers</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Students</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Manage Courses</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="announcements.php">Announcements</a>
                            </li>
                        </ul>
                    <div class="logout-button">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <!-- Page content -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>TechGenius Academy</h1>
                            <p>Unlock Your Potential, Empower Your Future!</p>
                            <p>Welcome, <?php echo $adminName; ?> (Admin)</p>
                        </div>
                    </div></br>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Announcement form -->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div></br>
                                <button type="submit" class="btn btn-primary">Post Announcement</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <!-- Announcement table -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date Posted</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($announcements as $announcement) { ?>
                                    <tr>
                                        <td><?php echo $announcement['title']; ?></td>
                                        <td><?php echo $announcement['postedDate']; ?></td>
                                        <td><?php echo $announcement['description']; ?></td>
                                        <td>
                                            <a href="deleteAnnouncement.php?announcementID=<?php echo $announcement['announcementID']; ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if (count($announcements) == 0) { ?>
                                    <tr>
                                        <td colspan="4">No announcements to display.</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>