<?php
date_default_timezone_set('Africa/Lagos');
require('../init.php');
$json = file_get_contents("php://input");
$obj = json_decode($json,true);

$card = $obj['cardnum'];
$type = $obj['type'];
$picker = $obj['picker'];

if($type == 'Arrival'){

	$stmt = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' "); // Get Student details

	$arrivalmessage =  $db->single_assoc("SELECT * from message");
	$arrival = $arrivalmessage['arrival'];
	$sender = $arrivalmessage['Sender'];
	$api_username = trim($arrivalmessage['api_username']);
	$api_password = trim($arrivalmessage['api_password']);

	/** SCHOOL  **/
	$sch =  $db->single_assoc("SELECT * from schools");
	$school_name = $sch['school_name'];
	/** SCHOOL  **/

	$count = $db->rowcount();
	$date = date('Y-m-d');
	$time = date('h:i:s');
	$student_name = $stmt['surname'] . " ". $stmt['other_name'];
	$phone = $stmt['phone'];
	$parent = $stmt['parent'];

	$log = array(
		"cardnum" => $card,
		"student_name" => $student_name,
		"type" => $type,
		"log_date" => $date,
		"log_time" => $time,
		"who" => $picker
	);

	if($db->insert('logs',$log)){
		if(is_sms_enabled()){
			sendmessage($arrival,$phone,$sender,$parent,$student_name,$api_username,$api_password);
		}
		
		$successLoginMsg = 1;
		$successLoginJson = json_encode($successLoginMsg);
		$param = array(
			'message' => 1
		);

		echo json_encode($param);
	}else{
		$param = array(
			'message' => 2
		);

		echo json_encode($param);
	}
	

}elseif($type == 'Departure') {
	$stmt = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' "); // Get Student details

	$departuremessage =  $db->single_assoc("SELECT * from message");
	$departure = $departuremessage['departure'];
	$sender = $departuremessage['Sender'];
	$api_username = trim($departuremessage['api_username']);
	$api_password = trim($departuremessage['api_password']);

	/** SCHOOL  **/
	$sch =  $db->single_assoc("SELECT * from schools");
	$school_name = $sch['school_name'];
	/** SCHOOL  **/

	$count = $db->rowcount();
	$date = date('Y-m-d');
	$time = date('h:i:s');
	$student_name = $stmt['surname'] . " ". $stmt['other_name'];
	$phone = $stmt['phone'];
	$parent = $stmt['parent'];

	$log = array(
		"cardnum" => $card,
		"student_name" => $student_name,
		"type" => $type,
		"log_date" => $date,
		"log_time" => $time,
		"who" => $picker
	);

	if($db->insert('logs',$log)){
		if(is_sms_enabled()){
			sendmessage($departure,$phone,$sender,$parent,$student_name,$api_username,$api_password);
		}
		
		$successLoginMsg = 1;
		$successLoginJson = json_encode($successLoginMsg);
		$param = array(
			'message' => 1
		);

		echo json_encode($param);
	}else{
		$param = array(
			'message' => 2
		);

		echo json_encode($param);
	}
}