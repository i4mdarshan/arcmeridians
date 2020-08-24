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
       $roomid=$_GET['room_id'];
       $mid=$_GET['member_id'];
       if(isset($_POST['upload']))
			{	
				$roomid=$_GET['room_id'];	
			    $dimension_title = $_POST['dimension_title'];
			    $description= $_POST['dimension_description'];
			    $image = $_FILES['dimensions_images']['name'];
			    $target = $_SERVER['DOCUMENT_ROOT']."/arcmeridians/modules/admin/dimensionimages/".$_FILES['dimensions_images']['name'];
			    $sql ="INSERT INTO `dimensions`(`room_id`,`dimension_title`,`dimension_description`,`dimensions_images`)VALUES ('$roomid','$dimension_title','$description','$image')";
				mysqli_query($conn, $sql);

			  	if (move_uploaded_file($_FILES['dimensions_images']['tmp_name'], $target)) {
			  		 $msg = "Image uploaded successfully!";
			  	}else{
			  		echo $msg = "Failed to upload image!";
			  	}
			  }
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
		if (isset($_GET['delete'])) {
				$id1 = $_GET['delete'];
				$id2 = $_GET['room_id'];
				$sql = "DELETE FROM dimensions Where dimension_id=$id1"; 

		if (mysqli_query($conn, $sql)) {
			    mysqli_close($conn);
			    header("Location:user-dimensions.php?room_id=".$id2."&member_id=".$_GET['member_id']);
			    exit;
		} else {
			    echo "Error deleting record";
			}
			    $_SESSION['message'] = "record has been deleted!";
			    $_SESSION['msg_type'] = "danger";
			        header("Location:user-dimensions.php?room_id=".$id2."&member_id=".$_GET['member_id']);

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
				      		    $dimage=$row['dimensions_images'];
				      		    $allowed = array('pdf','docx');
             					$ext= pathinfo($dimage, PATHINFO_EXTENSION);
				      			echo "<tr>";
							      	echo "<td>".$n."</td>";
							      	echo "<td><p>".$row['dimension_title']."</p></td>";
							        echo "<td>";
							        if (! in_array($ext, $allowed)) {
                       				echo "<img style='max-height:100px; max-width: 100px;' src='/arcmeridians/modules/admin/dimensionimages/".$row['dimensions_images']."'>";
                    				}
                  					else{echo "<p class='text-muted'>PDF File</p>";}
							        echo "</td>";
							        echo "<td>
							        <a class='btn btn-primary' href='user-view-dimensions.php?did=". $did ."&room_id=".$roomid."&member_id=".$mid."'>View</a>
							        <input type='button' class='btn btn-danger' onClick='deleteme(". $did .",".$roomid.",".$mid.")'value='Delete'></td>";
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
					<form method="post" class="form-horizontal" action="user-dimensions.php?room_id=<?php echo $_GET['room_id'] ?>&member_id=<?php echo $mid ?>" enctype="multipart/form-data">
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
 	function deleteme(did,rid,mid)
		{
			if (confirm("Are you sure you want to delete?")) {
				window.location.href='user-dimensions.php?delete='+did+'&room_id='+rid+'&member_id='+mid+'';
				return true;
			}
		}
 </script>

<?php  include'../../include/common/user-footer.php'; ?>