<?php
// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

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

// Add teacher form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_name = $_POST['teacherName'];
    $teacher_surname = $_POST['teacherSurname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hire_date = $_POST['hireDate'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    $query = "INSERT INTO teachers (teacherName, teacherSurname, email, password, hireDate, department, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $teacher_name, $teacher_surname, $email, $password, $hire_date, $department, $role);
    $stmt->execute();

    header('Location: adminhome.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <title>Add Teacher</title>
</head>
<body>
    <div class="container">
        <h2>Add Teacher</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="teacherName">Teacher Name:</label>
                <input type="text" class="form-control" id="teacherName" name="teacherName" required>
            </div>
            <div class="form-group">
                <label for="teacherSurname">Teacher Surname:</label>
                <input type="text" class="form-control" id="teacherSurname" name="teacherSurname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="hireDate">Hire Date:</label>
                <input type="date" class="form-control" id="hireDate" name="hireDate" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" class="form-control" id="role" name="role" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Teacher</button>
        </form>
    </div>
</body>
</html>