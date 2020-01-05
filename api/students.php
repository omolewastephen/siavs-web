<?php
require('../init.php');

$json = file_get_contents("php://input");
$obj = json_decode($json,true);

$action = $obj['action'];
if($action == 'fetch'){
	$stmt = $db->resultset_array("SELECT * FROM students");
	$count = $db->rowcount();
	if($count > 0){
		$successLoginMsg = 200;
		$param = array(
			'message' => $successLoginMsg ,
			'std' => $stmt
		);
		echo json_encode($param);
	}else{
		$invalidMsg = 404;
		$invalidMsgJson = json_encode($invalidMsg);
		$param = array('message' => $invalidMsg,'std' => array());
		echo json_encode($param);
	}

}
