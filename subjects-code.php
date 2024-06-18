<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "lab6");

// Check connection
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Function to retrieve department ID based on department name
function get_department_id($conn, $department_name) {
    $query = "SELECT dept_id FROM departments WHERE dept_name = '$department_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['dept_id'];
    } else {
        return null; // Department not found
    }
}

// Add subject
if (isset($_POST['subject_name']) && isset($_POST['subject_code']) && isset($_POST['department']) && isset($_POST['credits'])) {
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $department_name = mysqli_real_escape_string($conn, $_POST['department']);
    $credits = mysqli_real_escape_string($conn, $_POST['credits']);

    // Retrieve department ID
    $department_id = get_department_id($conn, $department_name);

    if ($department_id !== null) {
        $query = "INSERT INTO subjects (subject_name, subject_code, department, credits) VALUES ('$subject_name', '$subject_code', '$department_id', '$credits')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: subjects.php?success=Subject added successfully!");
            exit;
        } else {
            header("Location: subjects.php?error=Error adding subject: " . mysqli_error($conn));
            exit;
        }
    } else {
        header("Location: subjects.php?error=Error: Department does not exist.");
        exit;
    }
}
// Update subject
if (isset($_POST['subject_id']) && isset($_POST['subject_name']) && isset($_POST['subject_code']) && isset($_POST['department']) && isset($_POST['credits'])) {
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $credits = mysqli_real_escape_string($conn, $_POST['credits']);

    if (check_department_exists($conn, $department)) {
        $query = "UPDATE subjects SET subject_name = '$subject_name', subject_code = '$subject_code', department = '$department', credits = '$credits' WHERE subject_id = '$subject_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: subjects.php?success=Subject updated successfully!");
            exit;
        } else {
            header("Location: subjects.php?error=Error updating subject: " . mysqli_error($conn));
        }
    } else {
        header("Location: subjects.php?error=Error: Department does not exist.");
    }
}

// Delete subject
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['delete_subject_id'])) {
    $subject_id = mysqli_real_escape_string($conn, $_GET['delete_subject_id']);

    $query = "DELETE FROM subjects WHERE subject_id = '$subject_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("HTTP/1.1 200 OK");
        exit;
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        exit;
    }
}

// Close connection
mysqli_close($conn);
?>