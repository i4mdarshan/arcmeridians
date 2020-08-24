<?php
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["userloggedin"]) || $_SESSION["userloggedin"] !== true){
    header("location:/arcmeridians/userlogin.php");
    exit;
}
$title="Room | Finalised Designs";
$pid=$_GET['project_id'];
$mid=$_GET['member_id'];
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
    .imgbox{
      max-height:100px;
      max-width: 100px; 
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
        <a href="/arcmeridians/userwelcome.php?member_id=<?php echo $mid ?>" class="nav-link">Home</a>
      </li>
    </ul> 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- logout -->
      <li class="nav-item dropdown">
        <a class="nav-link text-muted" href="/arcmeridians/userlogout.php">
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
          <a href="#" class="d-block" style="text-transform: capitalize;"><?php echo $member_name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="overflow: hidden;">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="user-forums.php?project_id=<?php echo $pid; ?>" class="nav-link">
              <i class="nav-icon fa fa-comments-o"></i>
              <p>Discussions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/arcmeridians/modules/user/user-finalised-designs.php?project_id=<?php echo $pid; ?>&member_id=<?php echo $mid ?>" class="nav-link active">
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
            <h1 class="m-0 text-dark text-center">Finalised Designs</h1>
            <p><a class="btn btn-info" href="user-finalised-designs.php?project_id=<?php echo $pid ?>&member_id=<?php echo $_GET['member_id']; ?>"><i class="nav-icon fa fa-arrow-left"></i></a></p>
          </div><!-- /.col -->
         </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div><!-- /.content-header -->
      <?php 
        if (isset($_GET['view'])) {
            $id=$_GET['view'];
            $view = mysqli_query($conn, "SELECT `post_id`,`room_id`,`design_images`,`design_title`,`design_description` FROM `designs` WHERE project_id=$pid AND is_final=true AND post_id=$id");
            while ($row = mysqli_fetch_array($view)) {
                  $dimage=$row['design_images'];
                  $allowed = array('pdf','docx');
                  $ext= pathinfo($dimage, PATHINFO_EXTENSION);
                    echo "<div class='container-fluid'>
                        <div class='row'>
                            <div class='col-lg-12'> 
                        <div class='card text-center'>
                                <div class='card-body'>";
                          if (! in_array($ext, $allowed)) {
                          echo "<img style='overflow: auto; max-height: 600px;' class='img-fluid' src='/arcmeridians/modules/admin/designimages/".$row['design_images']."'>";
                            }
                          else{echo "<div class='mt-3 text-center'><a href='/arcmeridians/modules/admin/designimages/".$dimage."' target='_blank'>".$dimage."</a></div>";}
                          echo "
                                </div>
                              </div>
                            </div>";
                    echo "<div class='col-lg-12'>
                        <div class='card'>
                            <div class='card-body'>
                            <p><strong>Title: </strong>".$row['design_title']."</p>";
                    echo "<p><strong>Description: </strong>".$row['design_description']."</p>
                          </div>
                          </div>
                          </div>
                      </div>
                    </div>";     
          }
        }
      ?>
    </div>
	    <!-- Main Footer -->
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
