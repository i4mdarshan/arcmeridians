<?php

require('../../include/common/config.php');
include('roomprocess.php');
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:/arcmeridians/adminlogin.php");
    exit;
}

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
	
if(isset($_GET["project_id"]) && !empty(trim($_GET["project_id"]))){
	    
	    $sql="SELECT project_name,room_name
				FROM projects  
				INNER JOIN chatroom  
				ON chatroom.member_id=projects.member_id 
				INNER JOIN rooms  
				ON rooms.room_id=chatroom.room_id
				WHERE project_id =?";
	    if($stmt = mysqli_prepare($conn,$sql)){
	        
	        mysqli_stmt_bind_param($stmt, "i", $param_id);
	        
	        
	        $param_id = trim($_GET["project_id"]);
	        
	        
	        if(mysqli_stmt_execute($stmt)){
	            $result = mysqli_stmt_get_result($stmt);
	    
	            if(mysqli_num_rows($result) == 1){
	                
	                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	                
	                
	                $projectname = $row["project_name"];
	                $roomname = $row["room_name"];

	                
	            } else{
	               
	                echo "There was an error.";
	            }
	            
	        } else{
	            echo "Oops! Something went wrong. Please try again later.";
	        }
	   } 
	} else{
	    echo "There was an error in opening the project.";
	}

$title="New Project";
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
            <a href="<?php echo 'finalised-designs.php?project_id='. $_GET['project_id'] ?>" class="nav-link">
              <i class="nav-icon fa fa-check-square"></i>
              <p>
               Finalised Designs
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo 'addmember.php?project_id='. $_GET['project_id'] ?>" class="nav-link">
              <i class="nav-icon fa fa-plus-circle"></i>
              <p>
                Add Members
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
	            <a href="/arcmeridians/welcome.php" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            Rooms</h1>
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
	          <div class="col-lg">
	            <div class="card card-info">
	                <div class="card-body">
		    			<form class="form-inline" action="roomprocess.php?project_id=<?php echo $pid;?>" method="POST" id="a">
		    			<input type="hidden" name="id" value="<?php echo $id;  ?>"> 
		    				<label class="col-form-label">Room name: </label>
		    				&nbsp;
		    				<input type="text" class="col-sm-2 form-control" name="room_name" value="<?php echo $room_name; ?>">
		    				&nbsp;
		    				&nbsp;
		    				<?php if ($update == true): ?>        
		    				<input type="submit" class="btn btn-info" name="update" value="Update">
		    				<?php else: ?>
		    				<input type="submit" class="btn btn-info" name="addroom" value="Add">
		    			    <?php endif; ?>

		    			</form>
		    		</div>
	            </div>
		     
		    	<?php
	                    
	                    $display="SELECT room_id,room_name FROM rooms WHERE project_id=$pid";
	                    if($result = mysqli_query($conn,$display)){
	                        if(mysqli_num_rows($result) > 0){
	                            echo "<div class='card '>
	                                    <div class='card-body table-responsive p-0' style='height: 350px;'>
	                                      <table class='table table-striped table-head-fixed text-nowrap'>";
	                                echo "<thead>";
	                                    echo "<tr>";
	                                        
	                                        echo "<th>Sr No.</th>";
	                                        echo "<th>Room Name</th>";
	                                        echo "<th></th>";
	                                    echo "</tr>";
	                                echo "</thead>";
	                                echo "<tbody>";
	                                $n=1;
	                                while($row = mysqli_fetch_array($result)){
	                                    echo "<tr>";
	                                        
	                                        echo "<td>" . $n . "</td>";
	                                        echo "<td><a>" . $row['room_name'] . "</a></td>";
	                                        echo "<td class='project-actions text-right'>";
	                                        echo "<a class='btn btn-primary' href='viewroom.php?room_id=". $row['room_id'] ."&project_id=".$pid."'>
	                                        	<i class='fas fa-folder'>
	                                              </i>
	                                        	Open</a>
	                                        	<a class='btn btn-info' href='viewproject.php?edit=". $row['room_id'] ."&project_id=".$pid."'>
	                                        	<i class='fas fa-pencil-alt'>
	                                              </i>
	                                        	Edit</a>
	                                        	<input type='button' class='btn btn-danger' onClick='deleteme(". $row['room_id'] .",".$pid.")'value='Delete'>
	                                        	
	                                        	  </td>";
	                                        
	                                        $n++;
	                                    echo "</tr>";
	                                }
	                                echo "</tbody>";                            
	                            echo "</table>
	                            	</div>
	                            </div>";
	                            
	                            mysqli_free_result($result);
	                        } else{
	                            echo "<p class='lead'><em>No rooms were found.</em></p>";
	                        }
	                    } else{
	                        echo "ERROR: Could not able to execute ".mysqli_error($conn);
	                    }
	 
	         	?>
		    			
	            </div>
	        </div>
	    </div>
	</div>
</div>            
<script type="text/javascript">
		function goBack(){
      	window.history.back();
      	document.getElementById("a").reset();
		}
		function deleteme(room_id,project_id)
		{
			if (confirm("Are you sure you want to delete?")) {
				window.location.href='roomprocess.php?delete='+room_id+'&project_id='+project_id+'';
				return true;
			}
		}
</script>
<?php 
include'../../include/common/admin-footer.php';
?>
