<!-- Content area -->
<div class="content">
    <!-- Add content here -->
    <h5>Update Student:</h5>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="studentID">Enter Student ID:</label>
        <input type="number" id="studentID" name="studentID" required><br><br>
        <input type="submit" value="Fetch Student Details">
    </form>

    <?php
    // Include the database connection file
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['studentID']) && !empty($_POST['studentID']) && filter_var($_POST['studentID'], FILTER_VALIDATE_INT)) {
            $studentID = $_POST['studentID'];

            // Query to retrieve student details
            $query = "SELECT * FROM students WHERE studentID = :studentID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':studentID', $studentID, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="updateStudent.php" method="post">
                    <input type="hidden" name="studentID" value="<?php echo $studentID; ?>">
                    <label for="studentName">Name:</label>
                    <input type="text" id="studentName" name="studentName" value="<?php echo $row['studentName']; ?>"><br><br>
                    <label for="studentSurname">Surname:</label>
                    <input type="text" id="studentSurname" name="studentSurname" value="<?php echo $row['studentSurname']; ?>"><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>"><br><br>
                    <label for="enrollmentDate">Enrollment Date:</label>
                    <input type="date" id="enrollmentDate" name="enrollmentDate" value="<?php echo $row['enrollmentDate']; ?>"><br><br>
                    <label for="role">Role:</label>
                    <input type="text" id="role" name="role" value="<?php echo $row['role']; ?>"><br><br>
                    <input type="submit" value="Update Student">
                </form>
                <?php
            } else {
                echo "No student found with ID $studentID";
            }
        } else {
            echo "Invalid student ID";
        }
    }
    ?>
</div>