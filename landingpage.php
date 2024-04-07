<?php
// Start session
session_start();

// Include database connection
include('includes/db-conn.php');

// Connect to the database
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the user information from the database
$id = $_SESSION['id'];
$query = "SELECT * FROM profile WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Include header, topbar, and sidebar files
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<div class="wrapper">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>

              <div class="image">
    <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
  </div>
  <div class="info">
  <button type="button" class="btn btn-primary" onclick="location.href='standard-user-profile.php';">User Profile</button>   
  <a href="logout.php" class="d-block">Logout</a>      
  </i></a>
  </div>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    
               
   <?php
  include('includes/footer.php');
?>