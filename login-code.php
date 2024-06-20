<?php
session_start();
include ('includes/db-conn.php');

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to validate input data
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate email and password inputs
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $is_admin = validate($_POST['is_admin']);

    // Check if email or password is empty
    if (empty($email) || empty($password)) {
        // Redirect with error message if fields are empty
        header("Location: login.php?error=All fields are required");
        exit();
    } else {

        if ($is_admin) {
            // Hash the password before comparing (assuming you are storing hashed passwords)
            $query = "SELECT admin_id, password FROM admin WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify hashed password against user input
                if ($password == $hashed_password) {
                    $_SESSION['admin_id'] = $row['admin_id']; // Set session variable 'admin_id'
                    $_SESSION['role'] = 'Admin'; // Set session variable 'role'
                    header("Location: add-department.php");
                    exit();
                } else {
                    header("Location: login.php?error=Incorrect password");
                    exit();
                }
            } else {
                header("Location: login.php?error=User not found");
                exit();
            }
        } else {
            // Hash the password before comparing (assuming you are storing hashed passwords)
            $query = "SELECT student_id, password FROM students WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify hashed password against user input
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['student_id'] = $row['student_id']; // Set session variable 'student_id'
                    $_SESSION['role'] = 'Student'; // Set session variable 'role'
                    header("Location: students-page.php");
                    exit();
                } else {
                    header("Location: login.php?error=Incorrect password");
                    exit();
                }
            } else {
                header("Location: login.php?error=User not found");
                exit();
            }
        }
    }
}
?>
