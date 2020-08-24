<?php 
require('../../include/common/config.php');

    $room_name="";
    $update=false;
    $id= 0;
if (isset($_POST['addroom'])) {

	$room_name=$_POST['room_name'];   
	$pid=$_GET['project_id'];
	$query =mysqli_query($conn,"INSERT INTO rooms (room_name,project_id) values('$room_name','$pid')"); 
	$display=mysqli_query($conn,"SELECT room_name,room_id FROM rooms WHERE project_id=$pid");	
	if($query)
		{
		 header("Location:viewproject.php?project_id=".$_GET['project_id']);
         exit;
								  
		}else{ echo "Error!";}
	}

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$sql = "DELETE FROM rooms Where room_id=$id"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location:viewproject.php?project_id=".$_GET['project_id']);
    exit;
} else {
    echo "Error deleting record";
}
    $_SESSION['message'] = "record has been deleted!";
    $_SESSION['msg_type'] = "danger";
        header("Location:viewproject.php?project_id=".$_GET['project_id']);

}
if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$update =true;
	$result = $conn->query("SELECT room_name from rooms Where room_id=$id") or die($conn->error); 

 
	if(isset($result->num_rows) && $result->num_rows > 0){
	        $row = $result->fetch_array(MYSQLI_ASSOC);
	        $room_name=$row['room_name'];
	}
}
if (isset($_POST['update'])) {
	$id=$_POST['id'];
	$room_name=$_POST['room_name'];

     $conn->query("UPDATE rooms SET room_name= '$room_name' where room_id=$id") or die($conn->error); 

     $_SESSION['message'] = "record has been updated!";
     $_SESSION['msg_type'] = "warning!";

     header("Location:viewproject.php?project_id=".$_GET['project_id']);

}

?>

