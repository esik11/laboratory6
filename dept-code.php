<?php
include 'includes/db-conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['dept_name']) && isset($_POST['description'])) {
        // Add or update department
        $dept_name = $_POST['dept_name'];
        $description = $_POST['description'];
        
        if (isset($_POST['dept_id'])) {
            // Update department
            $dept_id = $_POST['dept_id'];
            $sql = "UPDATE departments SET dept_name='$dept_name', description='$description' WHERE dept_id='$dept_id'";
        } else {
            // Add new department
            $sql = "INSERT INTO departments (dept_name, description) VALUES ('$dept_name', '$description')";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: add-department.php?success=Department saved successfully");
        } else {
            header("Location: add-department.php?error=Error: " . $conn->error);
        }
    }
}  elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_id'])) {
    // Handle delete request
    $dept_id = $_GET['delete_id'];
    
    // Sanitize input to prevent SQL injection (you should use prepared statements for production)
    $dept_id = intval($dept_id);

    $sql = "DELETE FROM departments WHERE dept_id='$dept_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: add-department.php?success=Department deleted successfully");
        exit(); // Ensure no further code execution after redirect
    } else {
        header("Location: add-department.php?error=Error: " . $conn->error);
        exit(); // Ensure no further code execution after redirect
    }
}

$conn->close();
?>