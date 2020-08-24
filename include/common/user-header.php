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
        <a href="/arcmeridians/userwelcome.php?member_id=<?php echo $mid; ?>" class="nav-link">Home</a>
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
      <nav class="mt-2" style="overflow: hidden;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo 'user-view-room.php?room_id='. $roomid . '&member_id='. $mid; ?>" class="nav-link <?php echo $inspiration; ?> ">
              <i class="nav-icon fa fa-comments-o"></i>
              <p>
                Inspirations
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'user-dimensions.php?room_id='. $roomid . '&member_id='. $mid; ?>" class="nav-link <?php echo $dimension; ?> ">
              <i class="nav-icon fas fa-pencil-ruler"></i>
              <p>
               Dimensions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'user-designs.php?room_id='. $roomid . '&project_id='. $pid .'&member_id=' . $mid; ?>" class="nav-link <?php echo $design; ?> ">
              <i class="nav-icon fas fa-palette"></i>
              <p>
                Designs
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>