<?php
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["userloggedin"]) || $_SESSION["userloggedin"] !== true){
    header("location:/arcmeridians/userlogin.php");
    exit;
}
$design="active";
$title="Room | Designs";
$roomid=$_GET['room_id'];
$pid=$_GET['project_id'];
$mid=$_GET['member_id'];
$result = mysqli_query($conn, "SELECT post_id,design_title,design_description,design_images,post_time FROM designs WHERE room_id=$roomid");
$display=mysqli_query($conn,"SELECT member_name,project_id FROM members WHERE member_id=$mid");
		if ($display && $row=mysqli_fetch_assoc($display)) {
		    $member_name=$row["member_name"];
		    $pid=$row['project_id'];
		    }else{
		        "<script>
		        alert('Error loading project.');
		        </script>";
		    }
$display=mysqli_query($conn,"SELECT room_name FROM rooms WHERE room_id=$roomid");
	    if ($display && $row=mysqli_fetch_assoc($display)) {
	    	$room_name=$row['room_name'];
	    }else{
	    	"<script>
	    		alert('Error loading room.');
	    	</script>";
	    }

	include'../../include/common/user-header.php';
?>
<div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark">
	            <a href="/arcmeridians/userwelcome.php?member_id=<?php echo $mid; ?>" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            <?php echo $room_name; ?>Room</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">

	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	    <div class="content">
	      <div class="container-fluid">
	      	<div class="card-columns text-white">
			<?php

				while ($row = mysqli_fetch_array($result)) { 
						    	$postid=$row['post_id'];
						    	$post_time=$row['post_time'];
								echo "
									<a href='user-view-designs.php?view=". $postid ."&room_id=".$roomid."&project_id=". $pid ."&member_id=".$mid."' class='d-block mb-4 h-100'>
									<div class='card text-center mb-3 text-muted' id='card-ani'>
        								<div class='card-body'>
            							<img class='img-fluid' src='/arcmeridians/modules/admin/designimages/".$row['design_images']."' alt=''>
          								</div>
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
<?php  include'../../include/common/user-footer.php'; ?>