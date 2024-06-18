<?php
include "includes/db-conn.php";
include "includes/header.php";
include "includes/footer.php";
include "includes/sidebar.php";

// Retrieve subjects from the database
$sql_subjects = "SELECT subject_id, subject_name, subject_code, department, credits FROM subjects";
$result_subjects = $conn->query($sql_subjects);

// Retrieve departments from the database
$sql_departments = "SELECT dept_id, dept_name FROM departments";
$result_departments = $conn->query($sql_departments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">

  <style>
        .nav-item form {
            margin-top: 50px; 
        }
        #addDepartmentContainer {
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
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="students.php" class="nav-link">
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
              <h1 class="m-0">Subjects</h1>
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
              <h3 class="card-title">List of subjects</h3>
              <div class="card-tools">
                <button id="addBtn" class="btn btn-primary">Add</button>
              </div>
            </div>
            <div id="addSubjectContainer" class="card-body" style="display: none;">
              <form action="subjects-code.php" method="post">
                <div class="form-group">
                  <label for="subject_name">Subject Name</label>
                  <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                </div>
                <div class="form-group">
                  <label for="subject_code">Subject Code</label>
                  <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                </div>
                <div class="form-group">
                  <label for="department">Department</label>
                  <select class="form-control" id="department" name="department" required>
                    <?php
                    if ($result_departments->num_rows > 0) {
                      while($row = $result_departments->fetch_assoc()) {
                        echo "<option value='" . $row['dept_name'] . "'>" . $row['dept_name'] . "</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="credits">Credits</label>
                  <input type="text" class="form-control" id="credits" name="credits" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" id="clearFormBtn" class="btn btn-secondary">Clear</button>
              </form>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Department</th>
                    <th>Credits</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result_subjects->num_rows > 0) {
                    while($row = $result_subjects->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["subject_name"] . "</td>";
                      echo "<td>" . $row["subject_code"] . "</td>";
                      echo "<td>" . $row["department"] . "</td>";
                      echo "<td>" . $row["credits"] . "</td>";
                      echo "<td>";
                      echo "<button class='btn btn-primary btn-sm editBtn' data-id='" . $row["subject_id"] . "' data-name='" . $row["subject_name"] . "' data-code='" . $row["subject_code"] . "' data-department='" . $row["department"] . "' data-credits='" . $row["credits"] . "'>Edit</button> ";
                      echo "<button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row["subject_id"] . "'>Delete</button>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='5'>No subjects found</td></tr>";
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // URL Parameter Cleanup
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('error');
            url.searchParams.delete('success');
            window.history.replaceState({ path: url.href }, '', url.href);
        }

        // Automatic Message Hiding
        const alertMessages = document.querySelectorAll('.alert-danger, .alert-success');
        if (alertMessages) {
            alertMessages.forEach(function(message) {
                setTimeout(() => message.style.display = 'none', 4000);
            });
        }

        // Toggle add subject container
        const addBtn = document.getElementById('addBtn');
        const addSubjectContainer = document.getElementById('addSubjectContainer');

        addBtn.addEventListener('click', function() {
            if (addSubjectContainer.style.display === 'none' || addSubjectContainer.style.display === '') {
                addSubjectContainer.style.display = 'block';
            } else {
                addSubjectContainer.style.display = 'none';
            }
        });

        const tableBody = document.querySelector('.table tbody');

        // Show hidden edit form
        tableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('editBtn')) {
                const editFormId = `editForm_${event.target.dataset.id}`;
                const editForm = document.getElementById(editFormId);
                if (editForm.style.display === 'none' || editForm.style.display === '') {
                    editForm.style.display = 'table-row';
                } else {
                    editForm.style.display = 'none';
                }
            }
        });

        // Handle delete action
        tableBody.addEventListener('click', (event) => {
    if (event.target.classList.contains('deleteBtn')) {
        const rowId = event.target.dataset.id;
        if (confirm('Are you sure you want to delete this subject?')) {
            fetch(`subjects-code.php?delete_subject_id=${rowId}`, {
                method: 'DELETE'
            }).then(response => {
                if (response.ok) {
                    window.location.href = 'subjects.php?success=Subject deleted successfully';
                } else {
                    response.text().then(text => {
                        const errorMessage = response.headers.get('X-Error-Message') || 'Error deleting subject';
                        window.location.href = `subjects.php?error=${encodeURIComponent(errorMessage)}`;
                    });
                }
            }).catch(error => {
                window.location.href = `subjects.php?error=${encodeURIComponent('Error deleting subject')}`;
            });
        }
    }
});

        // Clear form fields
        const clearFormBtn = document.getElementById('clearFormBtn');
        clearFormBtn.addEventListener('click', function() {
            const textInputs = document.querySelectorAll('input[type="text"]');
            textInputs.forEach(function(input) {
                input.value = '';
            });

            const textAreas = document.querySelectorAll('textarea');
            textAreas.forEach(function(textArea) {
                textArea.value = '';
            });
        });
    });
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="jquery/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/adminlte.min.js"></script>

</body>

</html>

<?php
$conn->close();
?>