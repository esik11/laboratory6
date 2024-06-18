<?php
include 'includes/db-conn.php';
include 'includes/sidebar.php';
include 'includes/header.php';
include 'includes/footer.php';

// Retrieve departments from the database
$result_depts = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
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
    <!-- Navbar, Sidebar, Footer, etc. -->
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Departments</h1>
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
                            <h3 class="card-title">List of Departments</h3>
                            <div class="card-tools">
                                <button id="addDeptBtn" class="btn btn-primary">Add Department</button>
                            </div>
                        </div>

                        <div id="addDepartmentContainer" class="card-body">
                            <form action="dept-code.php" method="post">
                                <div class="form-group">
                                    <label for="dept_name">Department Name</label>
                                    <input type="text" class="form-control" id="dept_name" name="dept_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" id="clearDeptFormBtn" class="btn btn-secondary">Clear</button>
                            </form>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_depts->num_rows > 0) {
                                        while($row = $result_depts->fetch_assoc()) {
                                            echo "<tr id='dept_row_" . $row["dept_id"] . "'>";
                                            echo "<td>" . $row["dept_name"] . "</td>";
                                            echo "<td>" . $row["description"] . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-primary btn-sm editDeptBtn' data-id='" . $row["dept_id"] . "' data-name='" . $row["dept_name"] . "' data-description='" . $row["description"] . "'>Edit</button> ";
                                            echo "<button class='btn btn-danger btn-sm deleteDeptBtn' data-id='" . $row["dept_id"] . "'>Delete</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Add hidden edit form for each row
                                            echo "<tr id='editDeptForm_" . $row["dept_id"] . "' style='display:none;'>
                                                <td colspan='3'> 
                                                    <form action='dept-code.php' method='post'>
                                                        <div class='form-group'>
                                                            <label>Department Name</label>
                                                            <input type='hidden' name='dept_id' value='" . $row["dept_id"] . "'>
                                                            <input type='text' class='form-control' name='dept_name' value='" . $row["dept_name"] . "'>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Description</label>
                                                            <textarea class='form-control' name='description'>" . $row["description"] . "</textarea>
                                                        </div>
                                                        <button type='submit' class='btn btn-primary btn-sm'>Save</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No departments found</td></tr>";
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

    <!-- /.control-sidebar -->

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

    // Toggle add department container
    const addDeptBtn = document.getElementById('addDeptBtn');
    const addDepartmentContainer = document.getElementById('addDepartmentContainer');

    addDeptBtn.addEventListener('click', function() {
        if (addDepartmentContainer.style.display === 'none' || addDepartmentContainer.style.display === '') {
            addDepartmentContainer.style.display = 'block';
        } else {
            addDepartmentContainer.style.display = 'none';
        }
    });

    const tableBody = document.querySelector('.table tbody');

    // Show hidden edit form
    tableBody.addEventListener('click', (event) => {
        if (event.target.classList.contains('editDeptBtn')) {
            const editFormId = `editDeptForm_${event.target.dataset.id}`;
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
        if (event.target.classList.contains('deleteDeptBtn')) {
            const rowId = event.target.dataset.id;
            if (confirm('Are you sure you want to delete this department?')) {
                fetch(`dept-code.php?delete_id=${rowId}`, {
                    method: 'GET' // Use GET method for delete request
                }).then(response => {
                    if (response.ok) {
                        window.location.href = 'add-department.php?success=Department deleted successfully';
                    } else {
                        response.text().then(text => {
                            const errorMessage = response.headers.get('X-Error-Message') || 'Error deleting department';
                            window.location.href = `add-department.php?error=${encodeURIComponent(errorMessage)}`;
                        });
                    }
                }).catch(error => {
                    window.location.href = `add-department.php?error=${encodeURIComponent('Error deleting department')}`;
                });
            }
        }
    });

    // Clear form fields
    const clearDeptFormBtn = document.getElementById('clearDeptFormBtn');
    clearDeptFormBtn.addEventListener('click', function() {
        const textInputs = addDepartmentContainer.querySelectorAll('input[type="text"], textarea');
        textInputs.forEach(input => input.value = '');
    });
});
</script>

</body>
</html>
