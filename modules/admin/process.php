<?php
			$conn=mysqli_connect('localhost','root','1234','arcmeridians');

		if(!$conn){
		    die("Connection Failed".mysqli_connect_error());
		}echo "Database connected Successfully";

	if (isset($_GET['delete'])) {
			$projectid=$_POST['project_id'];
			echo $projectid;
			$delete=mysqli_query($conn,"DELETE FROM projects WHERE project_id=`$projectid`");
			if($delete){
			    if (mysqli_affected_rows($conn)>0) {
			        echo "Record deleted successfully";
			         exit;
			        }
			    else{
			          echo "error";
			                
			        }
			    }  
			}

?>