<?php
require_once'include/common/config.php';
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:adminlogin.php");
    exit;
}

$title="Projects";
include 'include/common/admin-header.php';

?>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-sm-inline-block">
        <a href="welcome.php" class="nav-link">Home</a>
      </li>
    </ul> 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- logout -->
      <li class="nav-item dropdown">
        <a class="nav-link text-muted" href="logout.php">
          Logout
          <i class="fa fa-sign-out"></i>  
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="include/img/arc_meridians_logo_white.png" alt="Logo" class="brand-image img-circle elevation-2"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><img src="include/img/arc_meridians_brandname@4x.png" style="height: 30px;"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="include/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="text-transform: capitalize;"><?php echo htmlspecialchars($_SESSION["username"]); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="modules/admin/newproject.php" class="nav-link">
              <i class="nav-icon fa fa-plus-circle"></i>
              <p>
                New Project
              </p>
            </a>
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
            <h1 class="m-0 text-dark">Your ongoing projects</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg">

            <?php
                    
                    $sql = "SELECT `project_name`,`location`,`startdate`,`project_id` FROM `projects` WHERE `delete_project`=false";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<div class='card'>
                                    <div class='card-body table-responsive p-0' style='height: 320px;'>
                                      <table class='table table-striped table-head-fixed text-nowrap'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Sr No.</th>";
                                        echo "<th>Project Name</th>";
                                        echo "<th>Location</th>";
                                        echo "<th></th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $n=1;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $n . "</td>";
                                        echo "<td>
                                                <a>" 
                                                . $row['project_name'] . 
                                                "</a>
                                                <br/>
                                                <small>Started at: "
                                                  . $row['startdate'] . 
                                                "</small>
                                              </td>";
                                        echo "<td>" . $row['location'] . "</td>";
                                        echo "<td class='project-actions text-right'>";
                                        echo "<a class='btn btn-primary btn-sm' href='modules/admin/viewproject.php?project_id=". $row['project_id'] ."' title='View Record' data-toggle='tooltip'>
                                              <i class='fas fa-folder'>
                                              </i>
                                              Open
                                              </a>";
                                            
                                        echo "</td>";
                                    echo "</tr>";
                                    $n++;
                                }
                                    echo "</tbody>";                            
                            echo "     </table>
                                      </div>
                                  </div>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }
 
                    // Close connection
                    mysqli_close($conn);
          ?>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 
include'include/common/admin-footer.php';
?>
