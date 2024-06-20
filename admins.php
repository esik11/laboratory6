<?php
session_start();
require_once('includes/db-conn.php');
include "includes/header.php";
include "includes/footer.php";

// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php?error=Unauthorized access");
    exit();
}

// Check if the user is an admin
if ($_SESSION['role'] !== 'Admin') {
    header("Location: students-page.php");
    exit();
}

// Retrieve admins from the database
$result_admins = $conn->query("SELECT * FROM admin");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admins Management</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="css/adminlte.min.css">
  <style>
        .nav-item form {
            margin-top: 50px; 
        }
        #addAdminContainer {
            display: none;
            margin-top: 20px;
        }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar, Sidebar, Footer, etc. -->
    <?php include "includes/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Admins Management</h1>
            </div>
          </div>
        </div>
      </div>

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
                            <h3 class="card-title">List of Admins</h3>
                            <div class="card-tools">
                                <button id="addAdminBtn" class="btn btn-primary">Add Admin</button>
                            </div>
                        </div>

                        <div id="addAdminContainer" class="card-body">
                            <form action="admin-code.php" method="post">
                                <div class="form-group">
                                    <label for="name">Admin Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="admin_email">Email</label>
                                    <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                                </div>
                                <div class="form-group">
                                    <label for="admin_password">Password</label>
                                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" id="clearAdminFormBtn" class="btn btn-secondary">Clear</button>
                            </form>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Admin Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_admins->num_rows > 0) {
                                        while($row = $result_admins->fetch_assoc()) {
                                            echo "<tr id='admin_row_" . $row["admin_id"] . "'>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>" . $row["email"] . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-primary btn-sm editAdminBtn' data-id='" . $row["admin_id"] . "' data-name='" . $row["name"] . "' data-email='" . $row["email"] . "'>Edit</button> ";
                                            echo "<button class='btn btn-danger btn-sm deleteAdminBtn' data-id='" . $row["admin_id"] . "'>Delete</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Add hidden edit form for each row
                                            echo "<tr id='editAdminForm_" . $row["admin_id"] . "' style='display:none;'>
                                                <td colspan='3'> 
                                                    <form action='admin-code.php' method='post'>
                                                        <div class='form-group'>
                                                            <label>Admin Name</label>
                                                            <input type='hidden' name='admin_id' value='" . $row["admin_id"] . "'>
                                                            <input type='text' class='form-control' name='name' value='" . $row["name"] . "'>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Email</label>
                                                            <input type='email' class='form-control' name='email' value='" . $row["email"] . "'>
                                                        </div>
                                                        <button type='submit' class='btn btn-primary btn-sm'>Save</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No admins found</td></tr>";
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
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
                            
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

    // Toggle add admin container
    const addAdminBtn = document.getElementById('addAdminBtn');
    const addAdminContainer = document.getElementById('addAdminContainer');

    addAdminBtn.addEventListener('click', function() {
        if (addAdminContainer.style.display === 'none' || addAdminContainer.style.display === '') {
            addAdminContainer.style.display = 'block';
        } else {
            addAdminContainer.style.display = 'none';
        }
    });

    const tableBody = document.querySelector('.table tbody');

    // Show hidden edit form
    tableBody.addEventListener('click', (event) => {
        if (event.target.classList.contains('editAdminBtn')) {
            const editFormId = `editAdminForm_${event.target.dataset.id}`;
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
        if (event.target.classList.contains('deleteAdminBtn')) {
            const rowId = event.target.dataset.id;
            if (confirm('Are you sure you want to delete this admin?')) {
                fetch(`admin-code.php?delete_id=${rowId}`, {
                    method: 'GET' // Use GET method for delete request
                }).then(response => {
                    if (response.ok) {
                        window.location.href = 'admins.php?success=Admin deleted successfully';
                    } else {
                        response.text().then(text => {
                            const errorMessage = response.headers.get('X-Error-Message') || 'Error deleting admin';
                            window.location.href = `admins.php?error=${encodeURIComponent(errorMessage)}`;
                        });
                    }
                }).catch(error => {
                    window.location.href = `admins.php?error=${encodeURIComponent('Error deleting admin')}`;
                });
            }
        }
    });

    // Clear form fields
    const clearAdminFormBtn = document.getElementById('clearAdminFormBtn');
    clearAdminFormBtn.addEventListener('click', function() {
        document.getElementById('name').value = '';
        document.getElementById('admin_email').value = '';
        document.getElementById('admin_password').value = '';
    });
});
</script>
</body>
</html>
