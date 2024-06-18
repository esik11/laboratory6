<?php
session_start();
include "includes/db-conn.php";
include 'includes/sidebar.php';
include 'includes/header.php';
include 'includes/footer.php';


// Retrieve departments from the database
$dept_sql = "SELECT dept_id, dept_name FROM departments";
$dept_result = $conn->query($dept_sql);

// Retrieve students from the database
$sql = "SELECT student_id, ID, first_name, lastname, CONCAT(first_name, ' ', lastname) AS table_name, email, department, status FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">

  <style>
    .nav-item form {
        margin-top: 50px; 
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
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
        <p><br></p>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

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
              <h1 class="m-0">Students</h1>
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
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Students List</h3>
                    <a href="add_student.php" class="btn btn-primary">Add Student</a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td><?php echo $row['ID']; ?></td>
                          <td><?php echo $row['table_name']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td><?php echo $row['department']; ?></td>
                          <td><?php echo $row['status']; ?></td>
                          <td>
                            <a href="students-code.php?action=approve&student_id=<?php echo $row['student_id']; ?>" class="btn btn-success btn-sm">Enroll</a>
                            <a href="students-code.php?action=decline&student_id=<?php echo $row['student_id']; ?>" class="btn btn-danger btn-sm">Decline</a>
                            <a href="students-code.php?action=delete&student_id=<?php echo $row['student_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editStudentModal" 
                              data-student_id="<?php echo $row['student_id']; ?>" 
                              data-first_name="<?php echo $row['first_name']; ?>" 
                              data-last_name="<?php echo $row['lastname']; ?>" 
                              data-department="<?php echo $row['department']; ?>">Edit</button>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal for editing student details -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="editStudentForm" method="post" action="students-code.php">
              <input type="hidden" name="student_id" id="edit-student_id">
              <div class="form-group">
                <label for="edit-first_name">First Name</label>
                <input type="text" class="form-control" id="edit-first_name" name="firstname" required>
              </div>
              <div class="form-group">
                <label for="edit-last_name">Last Name</label>
                <input type="text" class="form-control" id="edit-last_name" name="lastname" required>
              </div>
              <div class="form-group">
                <label for="edit-department">Department</label>
                <select class="form-control" id="edit-department" name="department">
                  <?php while($dept = $dept_result->fetch_assoc()): ?>
                    <option value="<?php echo $dept['dept_name']; ?>"><?php echo $dept['dept_name']; ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

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
  
  <script>
    $('#editStudentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var student_id = button.data('student_id');
      var first_name = button.data('first_name');
      var last_name = button.data('last_name');
      var department = button.data('department');
  
      var modal = $(this);
      modal.find('#edit-student_id').val(student_id);
      modal.find('#edit-first_name').val(first_name);
      modal.find('#edit-last_name').val(last_name);
      modal.find('#edit-department').val(department);
    });
  </script>

</body>
</html>

<?php $conn->close(); ?>
