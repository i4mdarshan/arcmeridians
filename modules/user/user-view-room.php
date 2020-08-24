<?php
require('../../include/common/config.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["userloggedin"]) || $_SESSION["userloggedin"] !== true){
    header("location:/arcmeridians/userlogin.php");
    exit;
}
$inspiration="active";
$title="Room | Inspirations";
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
$display=mysqli_query($conn,"SELECT room_name,project_id FROM rooms WHERE room_id=$roomid");
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
	</div>
<?php  include'../../include/common/user-footer.php'; ?>