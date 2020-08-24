<?php
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:/arcmeridians/adminlogin.php");
    exit;
}

  $title="Room | Designs";
	$pid=$_GET["project_id"];
	$display=mysqli_query($conn,"SELECT project_name,location,startdate FROM projects WHERE project_id=$pid");
	if ($display && $row=mysqli_fetch_assoc($display)) {
	    $project_name=$row["project_name"];
	    $location=$row["location"];
	    $startdate=$row["startdate"];
	    }else{
	    	"<script>
	    		alert('Error loading project.');
	    	</script>";
	    }

	$rid=$_GET["room_id"];
	$query= mysqli_query($conn,"SELECT admin_name FROM login WHERE admin_id=1");
	while ($row=mysqli_fetch_array($query)) {
				$adminname=$row['admin_name'];
			}

	$display=mysqli_query($conn,"SELECT room_name,project_id FROM rooms WHERE room_id=$rid");
	if ($display && $row=mysqli_fetch_assoc($display)) {
	    $room = $row['room_name'];
	}else{
	    	"<script>
	    	alert('Error loading room.');
	    	</script>";
	    }

$rid=$_GET['room_id'];
$pid=$_GET['project_id'];
if(isset($_POST['upload']))
			{	
				$rid=$_GET['room_id'];	
			    $design_title = $_POST['design_title'];
			    $description= $_POST['design_description'];
			    $image = $_FILES['design_images']['name'];
			    $target = "designimages/".$_FILES['design_images']['name'];
			    $sql ="INSERT INTO `designs`(`project_id`,`room_id`,`design_title`,`design_description`,`design_images`)VALUES ('$pid','$rid','$design_title','$description','$image')";
				mysqli_query($conn, $sql);

			  	if (move_uploaded_file($_FILES['design_images']['tmp_name'], $target)) {
			  		 $msg = "Image uploaded successfully";
			  	}else{
			  		 $msg = "Failed to upload image";
			  	}
			  }
  $result = mysqli_query($conn, "SELECT post_id,design_title,design_description,design_images,post_time FROM designs WHERE room_id=$rid");

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
      <li class="nav-item dropdown">
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

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/arcmeridians/include/img/home.jpg" class="img-circle elevation-2" alt="Home">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="text-transform: capitalize;">Project Info</a>
          <small class="d-block text-muted"><?php echo $project_name; ?></small>
          <small class="d-block text-muted"><?php echo $location; ?></small>
          <small class="d-block text-muted">Started on: <?php echo $startdate; ?></small>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2" style="overflow: hidden;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo 'viewroom.php?room_id='. $_GET['room_id'] . '&project_id='. $pid ?>" class="nav-link ">
              <i class="nav-icon fa fa-comments-o"></i>
              <p>
                Inspirations
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'admin-dimensions.php?room_id='. $_GET['room_id'] . '&project_id='. $pid ?>" class="nav-link">
              <i class="nav-icon fas fa-pencil-ruler"></i>
              <p>
               Dimensions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'admin-designs.php?room_id='. $_GET['room_id'] . '&project_id='. $pid ?>" class="nav-link active">
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

  <!-- Content wrapper -->
  <div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark">
	            <a href="viewproject.php?project_id=<?php echo $pid; ?>" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            <?php echo $room; ?>Room</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">

	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	    <div class="content">
	      <div class="container-fluid">
	        <div class="row text-center text-lg-left">
	            <div class="card card-info">
	                <div class="card-body">
	                    <form  class="form-inline" action="admin-designs.php?room_id=<?php echo $_GET['room_id'] ?>&project_id=<?php echo $pid ?>" method="POST" enctype="multipart/form-data">
	                                <input type="hidden" name="size" value="1000000">

	                                <label class="col-form-label">Title: </label>
	                                &nbsp;
	                                <input type="text" class="col-sm-2 form-control" name="design_title" Required>
	                                &nbsp;
	                                &nbsp;
	                                <label class="col-form-label">Description: </label>
	                                
	                                <textarea type="text" class="col-sm-3 form-control pt-2" name="design_description"></textarea>
	                                &nbsp;
	                               
									<input type="file" class="input-group-btn col-sm-3" name="design_images">
									
	                                <input type="submit" name="upload" class="btn btn-primary col-sm-2 mt-3" value="Upload Post">
	                                
	                    </form>
	                </div>
	             </div>
	        </div>
	            <div class="container-fluid">
	           		<div class="card-columns text-white">         
	           			<?php

						    while ($row = mysqli_fetch_array($result)) { 
						    	$postid=$row['post_id'];
                  $post_time=$row['post_time'];
                  $design_image = $row['design_images'];
                  $allowed = array('pdf','docx');
                  $ext= pathinfo($design_image, PATHINFO_EXTENSION);
								echo "
                  <a href='admin-view-designs.php?view=". $postid ."&room_id=".$rid."&project_id=". $pid ."' class='d-block mb-4 h-100'>
									<div class='card text-center mb-1 text-muted' id='card-ani'>
        								<div class='card-body'>";
                          if (! in_array($ext, $allowed)) {
                            echo "<img class='img-fluid' src='designimages/".$design_image."' alt='Photo'>";
                          }
                          else{echo "<div class='mt-3 text-center'><p>".$design_image."</p></div>";}
          			    echo"	</div>
          								<div class='card-footer'>
          									<h5 style='text-transform: capitalize;''>".$row['design_title']."</h5>
                            <span class='description'>Posted on: ".$post_time."</span>
          								</div>
    								</div>
                    </a>
									"; 
							}    	
				
						   ?>
	           		</div>
	            </div>
	        </div>
  </div>
</div>
<?php 
include'../../include/common/admin-footer.php';
?>