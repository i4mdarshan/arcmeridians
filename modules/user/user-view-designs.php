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

if (isset($_GET['view'])) {
	$post=$_GET['view'];
	$room=$_GET['room_id'];
	$view = mysqli_query($conn, "SELECT post_id,design_title,design_description,design_images,post_time FROM designs WHERE room_id=$room AND post_id=$post");
	$query= mysqli_query($conn,"SELECT member_name FROM members WHERE member_id=$mid");
	while ($row = mysqli_fetch_array($view)) {
		$design_image=$row['design_images'];
		$design_title=$row['design_title'];
		$design_description=$row['design_description'];
		$post_time=$row['post_time'];
		$query=mysqli_query($conn,"SELECT * FROM designs_comments WHERE post_id = $post ORDER BY comment_id DESC");
				       
		}
	}

$name= mysqli_query($conn,"SELECT admin_name FROM login WHERE admin_id=1");
	while ($row=mysqli_fetch_array($name)) {
				$adminname=$row['admin_name'];
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
	            <a href="/arcmeridians/modules/user/user-designs.php?member_id=<?php echo $mid; ?>
	            &room_id=<?php echo $roomid; ?>&project_id=<?php echo $pid; ?>" class="btn btn-info">
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
		     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8 col-xs-2">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="/arcmeridians/include/img/design.png" alt="User Image">
                  <span class="username" style="text-transform: capitalize;" ><?php echo $adminname; ?></span>
                  <span class="description">Shared at <?php echo $post_time; ?> </span>
                </div>
                <!-- /.user-block -->
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<?php 
                  $allowed = array('pdf','docx');
                  $ext= pathinfo($design_image, PATHINFO_EXTENSION);
                  if (! in_array($ext, $allowed)) {
                    echo "<img class='img-fluid pad' src='/arcmeridians/modules/admin/designimages/".$design_image."' alt='Photo'>";
                  }
                  else{echo "<div class='mt-3 text-center'><a href='designimages/".$design_image."' target='_blank'>".$design_image."</a></div>";}
                ?>
                <div class="mt-2"><p><?php echo $design_description; ?></p></div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form method="post" action="user-view-designs.php?view=<?php echo $post ?>&room_id=<?php echo $roomid ?>&project_id=<?php echo $pid ?>&member_id=<?php echo $mid ?>">
                  <img class="img-fluid img-circle img-sm" src="/arcmeridians/include/img/user.png" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                 <div class="row">
	                  <div class="img-push col-md-10">
	                  	<input type="hidden" name="comment_id" id="comment_id" value="0" />
	                    <input type="text" name="comment_content"  class="form-control form-control-sm" placeholder="Press send to post comment" required>
	                  </div>
	                  <div class="col-md-2">
                        <input class="btn btn-info d-inline" type="submit" name="submit" value="Send">
                      </div>
	             </div>
                </form>
              </div>
              <!-- /.card-footer -->
                            <div class="card-footer card-comments" style="overflow:auto; max-height: 350px;">
                <div class="card-comment">
                  <?php
                  while($row=mysqli_fetch_assoc($query)){
                  	$comment_sender_name=$row['comment_sender_name'];
					$comment=$row['comment'];
					$comment_time=$row['comment_time'];
					if ($comment_sender_name==$adminname) {
						$src="design.png";
					}else{
						$src="user.png";
					}
					echo "<img class='img-circle img-sm' src='/arcmeridians/include/img/".$src."' alt='User Image'>";
					echo "<div class='comment-text'>";
						echo "<span class='username'>";
							echo $comment_sender_name;
							echo "<span class='text-muted float-right'>".$comment_time."</span>";
						echo "</span>";
						echo $comment;
					echo "</div>";
								}
				  ?>
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-2">
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php
	if (isset($_POST["submit"])) {
		$error = '';
		$comment_content = '';
		if(empty($_POST["comment_content"]))
			{
			 $error .= '<p class="text-danger">Comment is required</p>';
			}
			else
			{
			 $comment_content = $_POST["comment_content"];
			}

			$query=mysqli_query($conn,"INSERT INTO `designs_comments` 
			 (`post_id`,`room_id`,`comment_sender_name`,`comment`) 
			 VALUES('$post','$roomid','$member_name','$comment_content')");
			if($error == ''&& $query)
			{
			  $error = "<label class='text-success'>Comment Added</label>";
			  echo "<meta http-equiv='refresh' content='0'>";
			}
	}

 ?>
</div>
<?php  include'../../include/common/user-footer.php'; ?>