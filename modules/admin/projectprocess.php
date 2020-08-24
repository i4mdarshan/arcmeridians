<?php 
require('../../include/common/config.php');

    $project_name=$location=$startdate="";
	$project_error="Please enter project name.";
	$update=false;
    $id= 0;

	if(isset($_POST['submit']))
			{	
				$adminid=1;	
			    $project_name = $_POST['project_name'];
			    $location = $_POST['location'];
			    $startdate = $_POST['startdate'];
			   
			    $insert = mysqli_query($conn,"INSERT INTO `projects`(`admin_id`,`project_name`,`location`,`startdate`)VALUES (1,'$project_name','$location','$startdate')");
				if($insert){
		              header("Location: newproject.php");
		              exit;
		            }
		            else{
		                echo "error";
		                
		            }
		        }
    
    if (isset($_GET['delete'])) {
	    $id = $_GET['delete'];
	    $sql = "UPDATE `projects` SET `delete_project`=true WHERE `project_id`=$id"; 

		if (mysqli_query($conn, $sql)) {
		    mysqli_close($conn);
		    header("Location:newproject.php");
		    exit;
		} else {
		    echo "Error deleting record";
		}
		    $_SESSION['message'] = "record has been deleted!";
		    $_SESSION['msg_type'] = "danger";
		        header("Location:newproject.php");

	}

    if (isset($_GET['edit'])){
	$id = $_GET['edit'];
	$update =true;
	$result = $conn->query("SELECT project_name,location,startdate from projects Where project_id=$id") or die($conn->error); 

 
	if(isset($result->num_rows) && $result->num_rows > 0){
	        $row = $result->fetch_array(MYSQLI_ASSOC);
	        $project_name=$row['project_name'];
	        $location=$row['location'];
	        $startdate=$row['startdate'];
	    }
    }
	
	if (isset($_POST['update'])) {
		$id=$_POST['id'];
		$project_name=$_POST['project_name'];
		$location=$_POST['location'];
		$startdate=$_POST['startdate'];

	     $conn->query("UPDATE projects SET project_name= '$project_name',location= '$location',startdate= '$startdate' where project_id=$id") or die($conn->error); 

	     $_SESSION['message'] = "record has been updated!";
	     $_SESSION['msg_type'] = "warning!";

	     header("Location:newproject.php");

	}

?>