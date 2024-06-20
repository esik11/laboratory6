<?php
session_start();
require_once('includes/db-conn.php');

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Unauthorized access");
    exit();
}

// Handle form submissions and deletions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new admin
    if (isset($_POST['name'], $_POST['admin_email'], $_POST['admin_password'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $admin_email = $conn->real_escape_string($_POST['admin_email']);
        $admin_password = ($conn->real_escape_string($_POST['admin_password']) );

        $sql = "INSERT INTO admin (name, email, password) VALUES ('$name', '$admin_email', '$admin_password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: admins.php?success=New admin added successfully");
        } else {
            header("Location: admins.php?error=Error adding admin: " . $conn->error);
        }
        exit();
    }

    // Update existing admin
    if (isset($_POST['admin_id'], $_POST['name'], $_POST['email'])) {
        $admin_id = (int)$_POST['admin_id'];
        $name = $conn->real_escape_string($_POST['name']);
        $admin_email = $conn->real_escape_string($_POST['email']);

        $sql = "UPDATE admin SET name='$name', email='$admin_email' WHERE admin_id=$admin_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: admins.php?success=Admin updated successfully");
        } else {
            header("Location: admins.php?error=Error updating admin: " . $conn->error);
        }
        exit();
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $sql = "DELETE FROM admin WHERE admin_id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admins.php?success=Admin deleted successfully");
    } else {
        header("Location: admins.php?error=Error deleting admin: " . $conn->error);
    }
    exit();
}

header("Location: admins.php");
exit();
