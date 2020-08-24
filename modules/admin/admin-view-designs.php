<?php 
require('../../include/common/config.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:/arcmeridians/adminlogin.php");
    exit;
}

	$rid=$_GET['room_id'];
	$pid=$_GET['project_id'];
	$postid=$_GET['view'];
	$title="Room | Designs";
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
	$query= mysqli_query($conn,"SELECT admin_name FROM login WHERE admin_id=1");
	while ($row=mysqli_fetch_array($query)) {
				$adminname=$row['admin_name'];
			}

	$display=mysqli_query($conn,"SELECT room_name,project_id FROM rooms WHERE room_id=$rid");
	if ($display && $row=mysqli_fetch_assoc($display)) {
	    $room_name = $row['room_name'];
	}else{
	    	"<script>
	    	alert('Error loading room.');
	    	</script>";
	    }

	if (isset($_GET['delete'])) {
		$id1 = $_GET['delete'];
		$id2= $_GET['room_id'];
		$id3=$_GET['project_id'];
		$sql = "DELETE FROM designs Where post_id=$id1"; 

	if (mysqli_query($conn, $sql)) {
	    mysqli_close($conn);
	    header("Location:admin-designs.php?room_id=".$id2."&project_id=".$id3);
	    exit;
	} else {
	    echo "Error deleting record";
	}
	    $_SESSION['message'] = "record has been deleted!";
	    $_SESSION['msg_type'] = "danger";
	        header("Location:admin-designs.php?room_id=".$id2."&project_id=".$id3);

	}

	if (isset($_GET['view'])) {
					  $post=$_GET['view'];
					  $room=$_GET['room_id'];
					  $view = mysqli_query($conn, "SELECT post_id,design_title,design_description,design_images,post_time FROM designs WHERE room_id=$room AND post_id=$post");
					  $query= mysqli_query($conn,"SELECT admin_name FROM login WHERE admin_id=1");
					  while ($row=mysqli_fetch_array($query)) {
					  	 $adminname=$row['admin_name'];
					  }
					  while ($row = mysqli_fetch_array($view)) {
			      				$design_image=$row['design_images'];
			      				$design_title=$row['design_title'];
			      				$design_description=$row['design_description'];
			      				$post_time=$row['post_time'];
							    $viewcomment=mysqli_query($conn,"SELECT * FROM designs_comments 
									WHERE post_id = $post
									ORDER BY comment_id DESC
									");
								
					}  
			    }

  // comment Submission
  if (isset($_POST["submit"])) {
    $error = '';
    $comment_content = '';
    if(empty($_POST["comment_content"]))
      {
       $error = '<p class="text-danger">Comment is required</p>';
      }
      else
      {
       $comment_content = $_POST["comment_content"];
      }

      $query=mysqli_query($conn,"INSERT INTO `designs_comments` 
       (`post_id`,`room_id`,`comment_sender_name`,`comment`) 
       VALUES('$post','$rid','$adminname','$comment_content')");
      if($error == ''&& $query)
      {
        $error = "<label class='text-success'>Comment Added</label>";
        echo "<meta http-equiv='refresh' content='0'>";
      }
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
<div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark">
	            <a href="admin-designs.php?project_id=<?php echo $pid; ?>&room_id=<?php echo $rid; ?>" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            <?php echo $room_name; ?>Room</h1>
	          </div><!-- /.col -->
	          	<div class="col-sm-2"></div>
	          	<div class="col-sm-2"></div>
	          	<div class="col-sm-1 pt-3">
	          	<?php echo"<input type='button' class='btn btn-danger' onClick='deleteme(". $postid .",".$rid.",".$pid.")'value='Delete post'>"; ?>
	            </div>
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>

	     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
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
                    echo "<img class='img-fluid pad' src='designimages/".$design_image."' alt='Photo'>";
                  }
                  else{echo "<div class='mt-3 text-center'><a href='designimages/".$design_image."' target='_blank'>".$design_image."</a></div>";}
                ?>
                <div class="mt-2"><p><?php echo $design_description; ?></p></div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form method="post" action="<?php echo "admin-view-designs.php?view=$postid&room_id=$rid&project_id=$pid" ?>">
                  <img class="img-fluid img-circle img-sm" src="/arcmeridians/include/img/design.png" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="row">
                      <div class="img-push col-md-10">
                      	<input type="hidden" name="comment_id" id="comment_id" value="0" />
                        <input type="text" name="comment_content"  class="form-control form-control-sm" placeholder="Press send to post comment" required>
                      </div>
                      <div class="col-md-2">
                        <input class="btn btn-info" type="submit" name="submit" value="Send">
                      </div>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer card-comments" style="overflow:auto; max-height: 350px;" >
                <div class="card-comment">
                  <?php
                  while($row=mysqli_fetch_array($viewcomment))
                   {
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

 </div>
<!-- </div> -->
<script type="text/javascript">
	function deleteme(postid,rid,pid)
		{
			if (confirm("Are you sure you want to delete?")) {
				window.location.href='admin-view-designs.php?delete='+postid+'&room_id='+rid+'&project_id='+pid+'';
				return true;
			}
		}
</script>
<?php 
include'../../include/common/admin-footer.php';
?>

