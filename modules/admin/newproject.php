<?php

// Include DB file and create required functions of the modules like DB queries
require('../../include/common/config.php');
include'projectprocess.php';
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:/arcmeridians/adminlogin.php");
    exit;
}
	
if (!$conn){
	die('Could not connect: ' . mysql_error());
	}
$title="New Project";
include '../../include/common/admin-header.php';
?>

<!-- Main content -->
<div class="wrapper">

  <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-sm-inline-block">
        <a href="/arcmeridians/welcome.php" class="nav-link">Home</a>
      </li>
    </ul> 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- logout -->
      <li class="nav-item dropdown" >
        <a class="nav-link text-muted" href="/arcmeridians/logout.php">
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
      <img src="/arcmeridians/include/img/arc_meridians_logo_white.png" alt="Logo" class="brand-image img-circle elevation-2"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><img src="/arcmeridians/include/img/arc_meridians_brandname@4x.png" style="height: 30px;"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/arcmeridians/include/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="text-transform: capitalize;"><?php echo htmlspecialchars($_SESSION["username"]); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2" style="overflow: hidden;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/arcmeridians/modules/admin/newproject.php" class="nav-link active">
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
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
            <a href="/arcmeridians/welcome.php" class="btn btn-info">
                <i class="nav-icon fa fa-arrow-left"></i>
                </a>
            Add new projects</h1>
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
            <div class="card card-info">
                <div class="card-body">
                    <form  class="form-inline" action="projectprocess.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                                <label class="col-form-label">Project Name: </label>
                                &nbsp;
                                <input type="text" class="col-sm-2 form-control" name="project_name" value="<?php echo $project_name; ?>" Required>
                                &nbsp;
                                &nbsp;
                                <label class="col-form-label">Location: </label>
                                &nbsp;
                                <input type="text" class=" col-sm-2 form-control" name="location" value="<?php echo $location; ?>">
                                &nbsp;
                                &nbsp;
                                <label class=" col-form-label">Start Date: </label>
                                &nbsp;
                                <input type="date" class=" col-sm-2 form-control" name="startdate" value="<?php echo $startdate; ?>">
                                &nbsp;
                                &nbsp;
                                <?php if ($update == true): ?>        
                                <input type="submit" name="update" class="btn btn-info" value="Update">
                                <?php else: ?>
                                <input type="submit" name="submit" class="btn btn-info" value="Submit" onclick="return mess();">
                                <?php endif; ?>
                            
                    </form>
                </div>
            </div>

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
                                $i=1;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $i . "</td>";
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
                                        echo "<a class='btn btn-info' href='newproject.php?edit=". $row['project_id']."'>
                                              <i class='fas fa-pencil-alt'>
                                              </i>
                                              Edit
                                              </a>
                                             <input type='button' class='btn btn-danger' onClick='deleteme(". $row['project_id'] .")'value='Delete'>
                                             ";
                                        echo "</td>";
                                        $i++;
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>
                                </div>
                            </div>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }

        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
		 function mess()
      {
        alert ("Project created successfully.");
        return true;
      }

      function deleteme(project_id)
        {
            if (confirm("Are you sure you want to delete?")) {
                window.location.href='newproject.php?delete='+project_id+'';
                return true;
            }
        }
</script>
<?php 
include'../../include/common/admin-footer.php';
?>
