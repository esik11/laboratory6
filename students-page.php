<?php
session_start();
require_once('includes/db-conn.php');
include "includes/header.php";
include "includes/footer.php";

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}


// Fetch logged-in user's information from the database
$student_id = $_SESSION['student_id'];
$sql_user = "SELECT department FROM students WHERE student_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $student_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 1) {
    $user_row = $result_user->fetch_assoc();
    $user_department = $user_row['department'];

    // Retrieve the department details
    $sql_department = "SELECT * FROM departments WHERE dept_name = ?";
    $stmt_department = $conn->prepare($sql_department);
    $stmt_department->bind_param("s", $user_department);
    $stmt_department->execute();
    $result_department = $stmt_department->get_result();

    $dept_row = $result_department->fetch_assoc();
    $dept_row_id = $dept_row['dept_id'];

    // Retrieve subjects based on user's department
    $sql_subjects = "SELECT subject_id, subject_name, subject_code, credits FROM subjects WHERE department = ?";
    $stmt_subjects = $conn->prepare($sql_subjects);
    $stmt_subjects->bind_param("s", $dept_row_id);
    $stmt_subjects->execute();
    $result_subjects = $stmt_subjects->get_result();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_id'])) {
        $selectedSubjectId = $_POST['subject_id'];

        // Check if the student is already enrolled in the subject
        $sql_check_enrollment = "SELECT * FROM student_subjects WHERE student_id = ? AND subject_id = ?";
        $stmt_check_enrollment = $conn->prepare($sql_check_enrollment);
        $stmt_check_enrollment->bind_param("ii", $student_id, $selectedSubjectId);
        $stmt_check_enrollment->execute();
        $result_check_enrollment = $stmt_check_enrollment->get_result();
        
        if ($result_check_enrollment->num_rows == 0) {
            // Insert the subject into the student_subjects table
            $sql_insert = "INSERT INTO student_subjects (student_id, subject_id) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $student_id, $selectedSubjectId);

            if ($stmt_insert->execute()) {
                header("Location: students-page.php?success=Subject added successfully!");
                exit();
            } else {
                header("Location: students-page.php?error=Error adding subject. Please try again.");
                exit();
            }
        } else {
            header("Location: students-page.php?error=You are already enrolled in this subject.");
            exit();
        }
    }

    // Fetch enrolled subjects for the current user
    $sql_enrolled_subjects = "SELECT subjects.subject_id, subjects.subject_name, subjects.subject_code, subjects.credits FROM subjects
                              INNER JOIN student_subjects ON subjects.subject_id = student_subjects.subject_id
                              WHERE student_subjects.student_id = ?";
    $stmt_enrolled_subjects = $conn->prepare($sql_enrolled_subjects);
    $stmt_enrolled_subjects->bind_param("i", $student_id);
    $stmt_enrolled_subjects->execute();
    $result_enrolled_subjects = $stmt_enrolled_subjects->get_result();

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Dashboard</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/adminlte.min.css">

        <!-- Additional CSS -->
        <style>
            .nav-item form {
                margin-top: 50px;
            }

            #addSubjectContainer {
                display: none;
                margin-top: 20px;
            }
        </style>

    </head>

    <body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                       aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light"></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo htmlspecialchars($user_department); ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>User profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="logout.php" method="post">
                                <button type="submit" id="signOutBtn" class="nav-link btn btn-primary btn-lg"
                                        style="padding: 5px 10px; height: auto; background-color: transparent; border: 1px solid #ccc;">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <span style="color: white; font-weight: bold;">Sign out</span>
                                    <span class="right badge badge-danger"></span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Subjects for Department: <?php echo htmlspecialchars($user_department); ?></h1>
                            <h1 class="m-0">WELCOME STUDENT ID: <?php echo htmlspecialchars($student_id); ?></h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>" . $_GET['success'] . "</div>";
                    } elseif (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>" . $_GET['error'] . "</div>";
                    }
                    ?>
 <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Add Subjects</h3>
            <div class="card-tools">
              <button id="addBtn" class="btn btn-primary">Add</button>
            </div>
          </div>
          <div id="addSubjectContainer" class="card-body" style="display: none;">
            <form action="students-page.php" method="post">
              <div class="form-group">
                <label for="subject_id">Select Subject</label>
                <select class="form-control" id="subject_id" name="subject_id" required>
                  <?php
                  while ($row = $result_subjects->fetch_assoc()) {
                    echo "<option value='" . $row['subject_id'] . "'>" . htmlspecialchars($row['subject_name']) . " (" . htmlspecialchars($row['subject_code']) . ")</option>";
                  }
                  ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Add Subject</button>
              <button type="button" id="clearFormBtn" class="btn btn-secondary">Clear</button>
            </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display enrolled subjects -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Enrolled Subjects</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>Subject Code</th>
                                                <th>Credits</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result_enrolled_subjects->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['subject_code']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['credits']) . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Footer</strong>
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        // Add your custom scripts here
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle add subject container
            const addBtn = document.getElementById('addBtn');
            const addSubjectContainer = document.getElementById('addSubjectContainer');

            addBtn.addEventListener('click', function () {
                if (addSubjectContainer.style.display === 'none' || addSubjectContainer.style.display === '') {
                    addSubjectContainer.style.display = 'block';
                } else {
                    addSubjectContainer.style.display = 'none';
                }
            });

            // Clear form fields
            const clearFormBtn = document.getElementById('clearFormBtn');
            clearFormBtn.addEventListener('click', function () {
                const textInputs = document.querySelectorAll('input[type="text"]');
                textInputs.forEach(function (input) {
                    input.value = '';
                });

                const textAreas = document.querySelectorAll('textarea');
                textAreas.forEach(function (textArea) {
                    textArea.value = '';
                });
            });
        });
    </script>
    </body>
    </html>

    <?php
} else {
    echo "Error: User not found.";
    exit();
}

$stmt_user->close();
$stmt_subjects->close();
$conn->close();
?>
