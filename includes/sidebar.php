<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        </div>

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