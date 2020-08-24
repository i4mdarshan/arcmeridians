<?php
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["userloggedin"]) || $_SESSION["userloggedin"] !== true){
    header("location:/arcmeridians/userlogin.php");
    exit;
}
 $dimension="active";
 $title="Room | Dimensions";
 $did=$_GET['did'];
 $roomid=$_GET['room_id'];
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
 		$result = mysqli_query($conn, "SELECT dimension_title,dimension_description,dimensions_images,dimension_id FROM dimensions WHERE room_id=$roomid");
 		$display=mysqli_query($conn,"SELECT room_name,project_id FROM rooms WHERE room_id=$roomid");
	    		 if ($display && $row=mysqli_fetch_assoc($display)) {
	    		 	$room_name=$row['room_name'];
	    		 	$pid=$row['project_id'];
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
	            <button class="btn btn-info" onclick="goBack()">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</button>
	            <?php echo $room_name; ?>Room</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">

	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	<?php 
					  
		$view = mysqli_query($conn, "SELECT dimension_title,dimension_description,dimensions_images,dimension_id FROM dimensions WHERE room_id=$roomid AND dimension_id=$did");
		while ($row = mysqli_fetch_array($view)) {
			   $dimage=$row['dimensions_images'];
			   $allowed = array('pdf','docx');
               $ext= pathinfo($dimage, PATHINFO_EXTENSION);   			
			echo "<div class='container-fluid'>
	        		<div class='row'>
	          			<div class='col-lg-12'> 
							<div class='card text-center'>
						      	<div class='card-body'>";
						      	if (! in_array($ext, $allowed)) {
                   				echo "<img style='overflow: auto; max-height: 600px;' class='img-fluid' src='/arcmeridians/modules/admin/dimensionimages/".$dimage."'>";
                  				}
                  				else{echo "<div class='mt-3 text-center'><a href='/arcmeridians/modules/admin/dimensionimages/".$dimage."' target='_blank'>".$dimage."</a></div>";}
					   echo "</div>
						    </div>
						</div>";
			      echo "<div class='col-lg-12'>
						    <div class='card'>
						      	<div class='card-body'>
						      	<p><strong>Title: </strong>".$row['dimension_title']."</p>";
						  echo "<p><strong>Description: </strong>".$row['dimension_description']."</p>
						    </div>
					    </div>
					</div>
			    </div>
			  </div>";       
			    }			
			?>
 </div>
<script type="text/javascript">
	function goBack(){
      	window.history.back();
		}
</script>
<?php  include'../../include/common/user-footer.php'; ?>