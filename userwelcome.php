<?php
require_once'include/common/config.php';
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["userloggedin"]) || $_SESSION["userloggedin"] !== true){
    header("location:userlogin.php");
    exit;
}

$title="Welcome | Your Rooms";
 
 $mid=$_GET["member_id"];
 $display=mysqli_query($conn,"SELECT member_name,project_id FROM members WHERE member_id=$mid");
 if ($display && $row=mysqli_fetch_assoc($display)) {
    $member_name=$row["member_name"];
    $pid=$row['project_id'];
    }else{
        "<script>
        alert('Error loading project.');
        </script>";
    }

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $title; ?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/arcmeridians/include/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/arcmeridians/include/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <style type="text/css">
    #card-ani {
    transition: 0.3s;
    border-radius: 5px;
    }

    #card-ani:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
    .custom-footer{
      color: #869099;
      position:auto;
      bottom: 0;
      padding: 10px 10px 0px 10px;
      width: 100%;
      height: 40px;
      text-align: center;
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
      <li class="nav-item d-sm-inline-block">
        <a href="userwelcome.php?member_id=<?php echo $mid; ?>" class="nav-link">Home</a>
      </li>
    </ul> 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- logout -->
      <li class="nav-item dropdown">
        <a class="nav-link text-muted" href="userlogout.php">
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
          <a href="#" class="d-block" style="text-transform: capitalize;"><?php echo $member_name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2" style="overflow: hidden;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="modules/user/user-forums.php?project_id=<?php echo $pid; ?>&member_id=<?php echo $mid ?>" class="nav-link">
              <i class="nav-icon fa fa-comments-o"></i>
              <p>Discussions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="modules/user/user-finalised-designs.php?project_id=<?php echo $pid; ?>&member_id=<?php echo $mid ?>" class="nav-link">
              <i class="nav-icon fa fa-check-square"></i>
              <p>
                Finalised Designs
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
          <div class="col">
            <h1 class="m-0 text-dark text-center">MY ROOMS</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
          </div> 
          <div class="col-md-6 col-xs">
	       <?php
            $mid=$_GET["member_id"];       
            $display="SELECT room_id,room_name FROM rooms WHERE project_id=$pid";
            if($result = mysqli_query($conn,$display)){
                if(mysqli_num_rows($result) > 0){
                    echo "<div class='card'>
                            <div class='card-body table-responsive p-0' style='height: 320px;'>
                                <table class='table table-striped table-head-fixed text-nowrap'>";
                        echo "<thead>";
                            echo "<tr>";
                                        
                                echo "<th>Sr No.</th>";
                                echo "<th>Room Name</th>";
                                echo "<th colspan='2' class='text-center'>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                            $n=1;
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                        
                                    echo "<td>" . $n . "</td>";
                                    echo "<td>" . $row['room_name'] . "</td>";
                                    echo "<td><a class='btn btn-primary' href='modules/user/user-view-room.php?room_id=". $row['room_id'] ."&member_id=".$mid."'>Open</a>
                                        	
                                        	  </td>";
                                        
                                        $n++;
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "   </table>
                                    </div>
                                  </div>";
                            
                            mysqli_free_result($result);
                } else{
                    echo "<p class='lead'><em>No rooms were found.</em></p>";
                    }
            } else{
                    echo "ERROR: Could not able to execute ".mysqli_error($conn);
                   }        
           ?>
           </div>
          <!-- /.col-md-4 -->
          <div class="col-md-3">
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <!-- Main Footer -->
  </div>
  <footer class="custom-footer">
    <strong><span style="color: #f0575a;">A</span>rc <span style="color: #f0575a;">M</span>eridians &copy; 2020.</strong> All rights reserved.
  </footer>
</div>

<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/arcmeridians/include/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/arcmeridians/include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/arcmeridians/include/js/adminlte.min.js"></script>

</body>
</html>
