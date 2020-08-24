<?php
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:/arcmeridians/adminlogin.php");
    exit;
}

	$title="Room | Dimensions";
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
	// Image Upload
	$rid=$_GET['room_id'];
	if(isset($_POST['upload']))
			{	
				$rid=$_GET['room_id'];	
			    $title = $_POST['dimension_title'];
			    $description= $_POST['dimension_description'];
			    $image = $_FILES['dimensions_images']['name'];
			    $target = "dimensionimages/".$_FILES['dimensions_images']['name'];
			    $sql ="INSERT INTO `dimensions`(`room_id`,`dimension_title`,`dimension_description`,`dimensions_images`)VALUES ('$rid','$title','$description','$image')";
				mysqli_query($conn, $sql);

			  	if (move_uploaded_file($_FILES['dimensions_images']['tmp_name'], $target)) {
			  		 $msg = "Image uploaded successfully!";
			  	}else{
			  		echo $msg = "Failed to upload image!";
			  	}
			  }
	$result = mysqli_query($conn, "SELECT dimension_title,dimension_description,dimensions_images,dimension_id,room_id FROM dimensions WHERE room_id=$rid");

if (isset($_GET['delete'])) {
	$id1 = $_GET['delete'];
	$id2 = $_GET['room_id'];
	$sql = "DELETE FROM dimensions Where dimension_id=$id1"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location:admin-dimensions.php?room_id=".$id2."&project_id=".$pid);
    exit;
} else {
    echo "Error deleting record";
}
    $_SESSION['message'] = "record has been deleted!";
    $_SESSION['msg_type'] = "danger";
        header("Location:admin-dimensions.php?room_id=".$id2."&project_id=".$pid);

}
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
            <a href="<?php echo 'admin-dimensions.php?room_id='. $_GET['room_id'] . '&project_id='. $pid ?>" class="nav-link active">
              <i class="nav-icon fas fa-pencil-ruler"></i>
              <p>
               Dimensions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'admin-designs.php?room_id='. $_GET['room_id'] . '&project_id='. $pid ?>" class="nav-link">
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
	        <div class="row">
	          <div class="col-lg-7">
	            <?php
					$n=1;
				    echo "<div class='card '>
					        <div class='card-body table-responsive p-0' style='height: 350px;'>
					            <table class='table table-striped table-head-fixed text-nowrap'>";
				      		echo "<thead>";
				      			echo"<tr>";
				      			    echo "<th>Sr No.</th>";
				      			    echo "<th>Title</th>";
				      			    echo "<th>Image</th>";
				      			    echo "<th>Actions</th>";
				      			echo"</tr>";
				      		echo "</thead>";
				      		echo "<tbody>";
				    while ($row = mysqli_fetch_array($result)) {
				      		    $did=$row['dimension_id'];
				      		    $room=$row['room_id'];
             					$dimage=$row['dimensions_images'];
             					$dtitle=$row['dimension_title'];
             					$allowed = array('pdf','docx');
             					$ext= pathinfo($dimage, PATHINFO_EXTENSION);
				      			echo "<tr>";
							      	echo "<td>".$n."</td>";
							      	echo "<td><p>".$dtitle."</p></td>";
							        echo "<td>";
							        if (! in_array($ext, $allowed)) {
                       				echo "<img style='max-height:100px; max-width: 100px;' src='dimensionimages/".$dimage."'>";
                    				}
                  					else{echo "<p class='text-muted'>PDF File</p>";}
							        echo "</td>";
							        echo "<td>
							        <a class='btn btn-primary' href='admin-view-dimensions.php?view=". $did ."&room_id=".$rid."&project_id=" . $pid . "'>View</a>
							        <input type='button' class='btn btn-danger' onClick='deleteme(". $did .",".$rid.",".$pid.")'value='Delete'></td>";
							    echo "</tr>"; 
					  $n++;      
				    }
				            echo "<tbody>";
					echo "</table>
							</div>
						</div>"; 
				  ?>
			  </div>
			  <div class="col-lg-5">
			  	 <div class="card card-info">
					<form method="post" class="form-horizontal" action="admin-dimensions.php?room_id=<?php echo $_GET['room_id'] ?>&project_id=<?php echo $pid ?>" enctype="multipart/form-data">
						<div class="card-body">
							<input type="hidden" name="size" value="1000000">
                  			<div class="form-group row">
								<label for="inputEmail3" class="col-sm-5 col-form-label">Title:</label>
								<div class="col-sm-7">
								<input type="text" class="form-control" id="inputEmail3" name="dimension_title" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-5 col-form-label">Description:</label>
								<div class="col-sm-7">
								<textarea class="form-control" id="inputEmail3" name="dimension_description"></textarea>
								</div>
							</div>
							<div class="input-group">
                				<label class="input-group-btn">
                        		<input type="file" name="dimensions_images" required>
                				</label>

            				</div>	
							<div>
								<input type="submit" name="upload" class="btn btn-primary" value="Upload">
							</div> 
						</div>  
					</form>
				  </div>
			  </div>
	           </div>
	   		</div>
		</div>
	</div>
 <script type="text/javascript">
 	function deleteme(did,rid,pid)
		{
			if (confirm("Are you sure you want to delete?")) {
				window.location.href='admin-dimensions.php?delete='+did+'&room_id='+rid+'&project_id='+pid+'';
				return true;
			}
		}
 </script>
<?php 
include'../../include/common/admin-footer.php';
?>