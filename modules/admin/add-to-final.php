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

	// $rid=$_GET["room_id"];
	$query= mysqli_query($conn,"SELECT admin_name FROM login WHERE admin_id=1");
	while ($row=mysqli_fetch_array($query)) {
				$adminname=$row['admin_name'];
			}
  if (isset($_GET['remove'])){
    $remove=$_GET['remove'];
    $sql=mysqli_query($conn,"UPDATE `designs` SET `is_final` = '0' WHERE `designs`.`post_id`=$remove");
    if ($sql) {
      echo "Removed Successfully!";
    }else{
       echo "Error";
    }
  }
	// $display=mysqli_query($conn,"SELECT room_name,project_id FROM rooms WHERE room_id=$rid");
	// if ($display && $row=mysqli_fetch_assoc($display)) {
	//     $room = $row['room_name'];
	// }else{
	//     	"<script>
	//     	alert('Error loading room.');
	//     	</script>";
	//     }
 //  $result = mysqli_query($conn, "SELECT post_id,design_title,design_description,design_images FROM designs WHERE room_id=$rid");

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
            <a href="<?php echo 'forums.php?project_id='. $_GET['project_id'] ?>" class="nav-link">
              <i class="nav-icon fa fa-comments-o"></i>
              <p>
                Discussions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'finalised-designs.php?project_id='. $_GET['project_id'] ?>" class="nav-link active">
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

  <!-- Content wrapper -->
  <div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark">
	            <a href="finalised-designs.php?project_id=<?php echo $pid;?>" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            Finalised Designs</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">

	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	<div class="content">
	  <div class="container-fluid">
	  	<div class="card">
	  	  <div class="card-body text-center">
		    <form class="form-group" method="POST">
		      <div class="row">
		      	<div class="col-md-3 col-xs-3"></div>
		      	<div class="col-md-3 col-xs-3">
      			 	<select class="form-control" name="room" required>
      			 		<option>Choose Room</option>
      			 		<?php 
      			 			$project=$_GET['project_id'];
      			 			$getrooms=mysqli_query($conn,"SELECT room_name,room_id FROM rooms WHERE project_id=$project");
      			 			while ($row=mysqli_fetch_array($getrooms)) {
      			 				echo "<option value='".$row['room_id']."'>".$row['room_name']."</option>";
      			 			}
      			 		?>
      			   </select>
  			    </div>
  			    <div class="col-md-3 col-xs-3">	
  			 	   <input class="btn btn-info" type="submit" name="get" value="Get"></input>
  			 	  </div>
			 	    <div class="col-md-3 col-xs-3"></div>
			  </div>
			</form>
		  </div>
		</div>
 	<?php if (isset($_POST['get'])) {
 				$rid=$_POST['room'];
 				$getimages=mysqli_query($conn,"SELECT post_id,design_images,design_title,design_description FROM designs WHERE room_id=$rid AND is_final=0");
echo "<div class='container-fluid'>
        <div class='card-columns text-white'> 
       <form method='post'>";
 				while ($row=mysqli_fetch_array($getimages)) {
 				 $postid=$row['post_id'];
         $design_image = $row['design_images'];
         $allowed = array('pdf','docx');
         $ext= pathinfo($design_image, PATHINFO_EXTENSION);

 			echo "<label class='image-checkbox'>
              <div class='card text-center mb-1 text-muted' id='card-ani'>
                <div class='card-body'>";
                    if (! in_array($ext, $allowed)) {
                       echo "<img class='img-fluid' src='designimages/".$row['design_images']."' alt='Photo' />";
                    }
                    else{echo "<div class='mt-3 text-center'><p>".$design_image."</p></div>";}
            echo"<input type='checkbox' name='image_check[]' value='".$postid."'>
                </div>
                    <div class='card-footer'>
                      <h5 style='text-transform: capitalize;''>".$row['design_title']."</h5>
                    </div>
                  <i class='glyphicon glyphicon-ok'></i>
               </div>
            </label>";
 						}
 				echo "<br>
         <div class='mt-3'>
         <input class='btn btn-info pt-2' type='submit' name='add' value='Add'></input>
         </div>
 				</form>
      </div>
     </div>";
 			}

 		if (isset($_POST['add'])) {
 			foreach ($_POST['image_check'] as $value) {
 			$sql=mysqli_query($conn,"UPDATE designs 
				  SET is_final=true
				  WHERE post_id=$value");
 			$sql;
 			}
      echo "<div class='text-center'><span class='text-success'>Added Successfully!</span></div>";
 	}
 	?>
 		</div>
	</div>
 </div>

 <script type="text/javascript">
 	$(".image-checkbox").each(function(){
    if($(this).find('input[type="checkbox"]').first().attr("checked")){
        $(this).addClass('image-checkbox-checked');
    }else{
        $(this).removeClass('image-checkbox-checked');
    }
});

// sync the input state
$(".image-checkbox").on("click", function(e){
    $(this).toggleClass('image-checkbox-checked');
    var $checkbox = $(this).find('input[type="checkbox"]');
    $checkbox.prop("checked",!$checkbox.prop("checked"));
  
    e.preventDefault();
});
 </script>
<?php 
include'../../include/common/admin-footer.php';
?>