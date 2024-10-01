<?php
// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

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

// Retrieve the admin's name from the database
if (isset($_SESSION['adminID'])) {
    $stmt = $conn->prepare("SELECT adminName FROM admin WHERE adminID = ?");
    $stmt->bind_param("i", $_SESSION['adminID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $adminName = $admin['adminName'];
} else {
    echo "Error: adminID is not set in the session.";
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Insert announcement into database
    $query = "INSERT INTO announcements (title, description, postedDate, postedBy) VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $title, $description, $adminName);
    $stmt->execute();

    // Redirect to same page to display new announcement
    header('Location: announcements.php');
    exit;
}

// Retrieve the announcement data from the database
$query = "SELECT * FROM announcements ORDER BY postedDate DESC";
$result = $conn->query($query);
$announcements = array();
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements - TechGenius Academy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            background-color: rgba(255, 255, 255, 0.4);
            /* Background Image */
            background-image: url('https://wallpapers.com/images/hd/anime-school-scenery-empty-classroom-oemz67vnyqdihizw.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: overlay;
        }
        /* Spinner Styles */
        #spinner {
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        #spinner.show {
            opacity: 1;
            visibility: visible;
        }
        #spinner.hide {
            opacity: 0;
            visibility: hidden;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: #0069d9;
            padding: 20px;
            border-right: 3px solid rgba(255, 193, 7, 0.8);
            overflow-y: auto;
        }
        .sidebar .school-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar .school-logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #fafafa;
        }
        .sidebar .nav {
            flex-direction: column;
        }
        .sidebar .nav-item {
            margin-bottom: 10px;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 193, 7, 0.8);
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .logout-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        .logout-button a {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .logout-button a:hover {
            color: rgba(255, 193, 7, 0.8);
        }
        /* Main Content Styles */
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .header-banner {
            width: 100%;
            text-align: center;
            background-color: #0069d9;
            color: #fff;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .header-banner .title {
            font-size: 36px;
            font-weight: 900;
            font-family: 'Orbitron', sans-serif;
            margin: 0;
        }
        .header-banner .subtitle {
            font-size: 24px;
            margin: 0;
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: rgba(255, 193, 7, 0.8);
        }
        .page-title h1 {
            font-family: 'Orbitron', sans-serif;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 20px;
        }
        .btn-primary:hover {
            background-color: #e0a800;
            color: #000;
        }
        /* Table Styles */
        table {
            background-color: #fff;
        }
        table th {
            background-color: #0069d9;
            color: #fff;
        }
        /* Footer */
        footer {
            background-color: #0069d9;
            padding: 20px;
            color: #fff;
            text-align: center;
            position: relative;
            margin-top: 20px;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
        }
        footer a:hover {
            color: #e0a800;
        }
        footer .footer-logo {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        footer .footer-logo img {
            width: 50px;
            height: 50px;
        }
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
            footer .footer-logo {
                position: static;
                transform: none;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="school-logo">
            <img src="logo.png" alt="School Logo" class="img-fluid rounded-circle">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="adminhome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageTeachers.php"><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageStudents.php"><i class="fas fa-user-graduate"></i> Manage Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manageCourses.php"><i class="fas fa-book"></i> Manage Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <!-- Sidebar End -->

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Banner -->
        <div class="header-banner">
            <span class="title">TECHGENIUS ACADEMY</span><br>
            <span class="subtitle">Unlock Your Potential, Empower Your Future!</span>
        </div>
        <!-- Page Title -->
        <div class="page-title">
            <h1>Announcements</h1>
        </div>
        <!-- Announcement Form -->
        <div class="card">
            <div class="card-header">
                <h2>Post a New Announcement</h2>
            </div>
            <div class="card-body">
                <form action="announcements.php" method="post">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div><br>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
                    </div><br>
                    <button type="submit" class="btn btn-primary">Post Announcement</button>
                </form>
            </div>
        </div>
        <!-- Announcements List -->
        <div class="card">
            <div class="card-header">
                <h2>Announcements</h2>
            </div>
            <div class="card-body">
                <?php if (count($announcements) > 0) { ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date Posted</th>
                                <th>Description</th>
                                <th>Posted By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($announcements as $announcement) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($announcement['title']); ?></td>
                                    <td><?php echo htmlspecialchars($announcement['postedDate']); ?></td>
                                    <td><?php echo htmlspecialchars($announcement['description']); ?></td>
                                    <td><?php echo htmlspecialchars($announcement['postedBy']); ?></td>
                                    <td>
                                        <a href="deleteAnnouncement.php?announcementID=<?php echo $announcement['announcementID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No announcements to display.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <!-- Small School Logo -->
        <div class="footer-logo">
            <img src="logo.png" alt="School Logo">
        </div>
        <p>&copy; 2023 TechGenius Academy | <a href="#">About Us</a> | <a href="#">Contact Us</a> | <a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a></p>
    </footer>
    <!-- Main Content End -->
    <!-- jQuery and Bootstrap JS (Required for the spinner and functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Spinner Script -->
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $('#spinner').addClass('hide');
            }, 500); // Adjust the timeout as needed
        });
    </script>
</body>
</html>
