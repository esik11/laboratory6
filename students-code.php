<?php
include "includes/db-conn.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['student_id'])) {
    $action = $_GET['action'];
    $student_id = $_GET['student_id'];

    switch ($action) {
        case 'approve':
            $update_sql = "UPDATE students SET status='enrolled' WHERE student_id='$student_id'";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: students.php?message=Student enrolled successfully");
            } else {
                header("Location: students.php?error=Error enrolling student: " . $conn->error);
            }
            break;
        case 'decline':
            $update_sql = "UPDATE students SET status='declined' WHERE student_id='$student_id'";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: students.php?message=Student declined successfully");
            } else {
                header("Location: students.php?error=Error declining student: " . $conn->error);
            }
            break;
        case 'delete':
            $delete_sql = "DELETE FROM students WHERE student_id='$student_id'";
            if ($conn->query($delete_sql) === TRUE) {
                header("Location: students.php?message=Student deleted successfully");
            } else {
                header("Location: students.php?error=Error deleting student: " . $conn->error);
            }
            break;
        default:
            header("Location: students.php?error=Invalid action");
            break;
    }
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $department = $_POST['department'];

    $update_sql = "UPDATE students SET first_name='$firstname', lastname='$lastname', department='$department' WHERE student_id='$student_id'";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: students.php?message=Student updated successfully");
    } else {
        header("Location: students.php?error=Error updating student: " . $conn->error);
    }
    exit();
}

$conn->close();
?>
