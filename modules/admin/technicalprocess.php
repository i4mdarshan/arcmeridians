<?php 
require('../../include/common/config.php');

        $pid=$_GET['project_id'];
        $title1=$description=$image="";
        $id=0;
        $update=false;
		if(isset($_POST['upload']))
			{	
				$project=$_GET['project_id'];	
			    $title1 = $_POST['title'];
			    $description= $_POST['description'];
			    $image = $_FILES['images']['name'];
			    $target = "technicalimages/".$_FILES['images']['name'];
			    $sql ="INSERT INTO `technical_drawings`(`technical_title`,`technical_description`,`technical_images`,`project_id`)VALUES ('$title1','$description','$image','$pid')";
				
			  	if (move_uploaded_file($_FILES['images']['tmp_name'], $target) && mysqli_query($conn, $sql)) {
			  		echo $msg = "Image uploaded successfully!";
			  		 header("Location:technical-drawings.php?project_id=".$_GET['project_id']);
         			 exit;
			  	}else{
			  		echo "Failed to upload image!".mysqli_error($conn);
			  	}
			  }
			  $result = mysqli_query($conn,"SELECT technical_title,technical_description,technical_images,img_id FROM technical_drawings WHERE project_id=$pid");

		if (isset($_GET['delete'])) {
			$id1 = $_GET['delete'];
			$id2 = $_GET['project_id'];
			$sql = "DELETE FROM technical_drawings Where img_id=$id1"; 

		if (mysqli_query($conn, $sql)) {
		    mysqli_close($conn);
		    header("Location:technical-drawings.php?project_id=".$id2);
		    exit;
		} else {
		    echo "Error deleting record";
		}
		    $_SESSION['message'] = "record has been deleted!";
		    $_SESSION['msg_type'] = "danger";
		        header("Location:technical-drawings.php?project_id=".$id2);

		}

if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$update =true;
	$result = $conn->query("SELECT technical_title,technical_description,technical_images from technical_drawings WHERE img_id=$id") or die($conn->error); 

 
	if(isset($result->num_rows) && $result->num_rows > 0){
	        $row = $result->fetch_array(MYSQLI_ASSOC);
	        $title1=$row['technical_title'];
	        $description=$row['technical_description'];
	        $image=$row['technical_images'];
	}
}
if (isset($_POST['update'])) {
	$id=$_POST['id'];
	$title1 = $_POST['title'];
	$description= $_POST['description'];
	$image = $_FILES['images']['name'];

    $conn->query("UPDATE technical_drawings SET technical_title= '$title1',technical_description='$description',technical_images='$image' where img_id=$id") or die($conn->error); 

     $_SESSION['message'] = "record has been updated!";
     $_SESSION['msg_type'] = "warning!";

     header("Location:technical-drawings.php?project_id=".$_GET['project_id']);

}


?>