<?php
require('../../include/common/config.php');

$result=array();
$message=isset($_POST['message']) ? $_POST['message'] : null;
$from=isset($_POST['from']) ? $_POST['from'] : null;
$rid=isset($_POST['rid']) ? $_POST['rid'] : null;

if (!empty($message) && !empty($from)) {
	$sql="INSERT INTO `chatroom`(`chat_name`,`chat_messages`,`room_id`) VALUES('".$from."','".$message."','".$rid."')";
	$result['send_status']=$conn->query($sql);
}

$start= isset($_GET['start']) ? intval($_GET['start']) : 0;
$rid= isset($_GET['rid']) ? intval($_GET['rid']) : 0;
$items=$conn->query("SELECT * FROM `chatroom` WHERE room_id=". $rid ." AND `chat_id` > " . $start);
while ($row = $items->fetch_assoc()){
	$result['items'][] = $row;
	}


$conn->close();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode($result);

?>

