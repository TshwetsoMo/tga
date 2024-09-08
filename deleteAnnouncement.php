<?php
// deleteAnnouncement.php

// Include the database connection file
require_once 'db.php';

// Check if the user is logged in and has the admin role
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Get the announcement ID from the GET parameter
$announcementID = $_GET['announcementID'];

// Delete the announcement from the database
$query = "DELETE FROM announcements WHERE announcementID = :announcementID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':announcementID', $announcementID);
$stmt->execute();

// Redirect back to the announcements page
header('Location: announcements.php');
exit;
?>