<?php

ob_start(); // Start output buffering

include "includes/db-conn.php";
include 'includes/sidebar.php';
include 'includes/header.php';
include 'includes/footer.php';

// Function to generate random 5-digit number
function generateRandomNumber() {
    return str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

// Retrieve departments from the database
$dept_sql = "SELECT dept_id, dept_name FROM departments";
$dept_result = $conn->query($dept_sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name']; // Fixed the typo here
    $email = $_POST['email'];
    $department = $_POST['department'];
    $status = 'pending'; // Default status for new students
    $default_password = password_hash('default123', PASSWORD_DEFAULT); // Hash the default password

    // Generate random 5-digit number for ID
    $ID = generateRandomNumber();

    // Using prepared statements to insert the data
    $insert_sql = $conn->prepare("INSERT INTO students (ID, first_name, lastname, email, department, status, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_sql->bind_param("sssssss", $ID, $first_name, $last_name, $email, $department, $status, $default_password);

    if ($insert_sql->execute()) {
        header("Location: students.php?message=Student added successfully");
        exit();
    } else {
        header("Location: add_student.php?error=Error adding student: " . $insert_sql->error);
        exit();
    }

    $insert_sql->close();
}

$conn->close();

ob_end_flush(); // Flush the output buffer
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Student</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/phlcss/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
        <p><br></p>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="students_table.php" class="nav-link">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <p>Students</p>
                  </a>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="teachers_table.php" class="nav-link">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Teachers</p>
                  </a>
              </ul>
              <br>
              <hr>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="add-department.php" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Departments</p>
                  </a>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="subjects.php" class="nav-link">
                    <i class="fas fa-book nav-icon"></i>
                    <p>Subjects</p>
                  </a>
              </ul>
              <br>
              <hr>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="admin_dash.php" class="nav-link">
                    <i class="fas fa-user-alt nav-icon"></i>
                    <p>User profile</p>
                  </a>
              </ul>
            </li>
            <li class="nav-item">
              <form action="logout.php" method="post">
                <button type="submit" id="signOutBtn" class="nav-link btn btn-primary btn-lg" style="padding: 5px 10px; height: auto; background-color: transparent; border: 1px solid #ccc;">
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
              <h1 class="m-0">Add Student</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success">
                  <?php echo $_GET['message']; ?>
                </div>
              <?php endif; ?>
              
              <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                  <?php echo $_GET['error']; ?>
                </div>
              <?php endif; ?>

              <div class="card">
                <div class="card-body">
                  <form method="post" action="add_student.php">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="department">Department</label>
                      <select class="form-control" id="department" name="department" required>
                        <?php while($dept = $dept_result->fetch_assoc()): ?>
                          <option value="<?php echo $dept['dept_name']; ?>"><?php echo $dept['dept_name']; ?></option>
                        <?php endwhile; ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="js/adminlte.js"></script>
</body>
</html>
