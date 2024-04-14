<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "ipt101";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getLoggedInUserId() {
    if (isset($_SESSION['id'])) {
        return $_SESSION['id'];
    } else {
        return null;
    }
}


$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the subject from the database
if ($subject_id > 0) {
    $user_id = getLoggedInUserId();
    $sql = "DELETE FROM subjects2 WHERE id = $subject_id AND user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div>Subject deleted successfully.</div>";
    } else {
        echo "<div>Error deleting subject.</div>";
    }
}


header('Location: subjects.php');
exit;

// Close database connection
$conn->close();
?>