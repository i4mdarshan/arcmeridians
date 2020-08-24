<?php

// Include DB file and create required functions of the modules like DB queries
require('../../include/common/config.php');
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


	$member_name=$mail=$contact="";
	$member_error="Please enter member name.";
	$mail_error ="Please enter mail.";

	if(isset($_POST['submit']))
			{	
				$projectid=$_GET['project_id'];	
			    $member_name = $_POST['member_name'];
			    $mail= $_POST['member_mail'];
			    $contact = $_POST['contact'];
			    $chars="0123456789";
			    $mpass=substr(str_shuffle($chars),0,4);
			    $insert = mysqli_query($conn,"INSERT INTO `members`(`project_id`,`member_name`,`member_mail`,`contact`,`member_pass`)VALUES ('$projectid','$member_name','$mail','$contact','$mpass')");
				if($insert){
		            if (mysqli_affected_rows($conn)>0) {
		              header("Location: addmember.php?project_id=".$_GET['project_id']);
		              exit;
		            }
		            else{
		                echo "error";
		                
		            }
		        }

			    if(!$insert)
			    {
			        echo mysqli_error($conn);
			    }
			    else
			    {
			        echo "Added successfully.";
			    }
			}

	if (!$conn){
		die('Could not connect: ' . mysql_error());
		}

	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$sql = "DELETE FROM members Where member_id=$id"; 

	if (mysqli_query($conn, $sql)) {
	    mysqli_close($conn);
	    header("Location:addmember.php?project_id=".$_GET['project_id']);
	    exit;
	} else {
	    echo "Error deleting record";
	}
	    $_SESSION['message'] = "record has been deleted!";
	    $_SESSION['msg_type'] = "danger";
	        header("Location:addmember.php?project_id=".$_GET['project_id']);

	}
	$title="Add members";
	include '../../include/common/admin-header.php';	

?>
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
            <a href="<?php echo 'addmember.php?project_id='. $_GET['project_id'] ?>" class="nav-link active">
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
	            <a href="viewproject.php?project_id=<?php echo $_GET['project_id']; ?>" class="btn btn-info">
	    		<i class="nav-icon fa fa-arrow-left"></i>
	    		</a>
	            Add new members</h1>
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
						<form class="form-inline" method="POST" id="f">
							
									<label class="col-form-label">Name: </label>
									&nbsp;
									<input type="text" class="col-sm-2 form-control" name="member_name" Required>
									&nbsp;
									&nbsp;
									<label class="col-form-label">Email id: </label>
									&nbsp;
									<input type="mail" class="col-sm-2 form-control" name="member_mail" Required>
									&nbsp;
									&nbsp;
									<label class="col-form-label">Contact: </label>
									&nbsp;
									<input type="number" class="col-sm-2 form-control" name="contact" >
									&nbsp;
									&nbsp;
									<input type="submit" name="submit" class="btn btn-info" value="Submit" onclick="return mess();">
						</form>
					</div>
	            </div>
	<?php
                    $projectid=$_GET['project_id'];
                    
                    $sql = "SELECT member_name,member_mail,contact,member_id,member_pass FROM members WHERE project_id=$projectid";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<div class='card'>
                                    <div class='card-body table-responsive p-0' style='height: 320px;'>
                                      <table class='table table-striped table-head-fixed text-nowrap'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        
                                        echo "<th>Sr No.</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Email(USERNAME)</th>";
                                        echo "<th>Contact</th>";
                                        echo "<th>Pin(PASSWORD)</th>";
                                        echo "<th></th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $i=1;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row['member_name'] . "</td>";
                                        echo "<td>" . $row['member_mail'] . "</td>";
                                        echo "<td>" . $row['contact'] . "</td>";
                                        echo "<td>".  $row['member_pass']."</td>";
                                        echo "<td>
                                        	<input type='button' class='btn btn-danger' onClick='deleteme(". $row['member_id'] .",".$projectid.")'value='Delete'>
                                        	 </td>";
                                        $i++;
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>
                                </div>
                            </div>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }
 
                    
                ?>
	            </div>
	        </div>
	    </div>
    </div>
</div>
<script type="text/javascript">
		 function mess()
      {
        alert ("Member added successfully!");
        return true;
      }
      function deleteme(member_id,project_id)
		{
			if (confirm("Are you sure you want to delete?")) {
				window.location.href='addmember.php?delete='+member_id+'&project_id='+project_id+'';
				return true;
			}
		}
</script>
<?php 
include'../../include/common/admin-footer.php';
?>