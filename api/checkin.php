<?php
require('../init.php');
$json = file_get_contents("php://input");
$obj = json_decode($json,true);

$card = $obj['cardnum'];


$stmt = $db->single("SELECT * FROM students WHERE cardnum = '{$username}' ");
// Save to log
$log = array(
	"cardnum" => $stmt->cardnum,
	"student_name" => $stmt->surname . " ". $stmt->other_name,
	"type" => 'arrival',
	"log_date" => date('Y-m-d'),
	"log_time" => date('h:i:s')
);
$count = $db->rowcount();

if($count > 0){
	$insert = $db->insert('logs',$logs);
	$successLoginMsg = 1;
	$successLoginJson = json_encode($successLoginMsg);
	$param = array(
		'message' => 1
	);
	echo json_encode($param);
}else{
	$invalidMsg = 0;
	$invalidMsgJson = json_encode($invalidMsg);
	echo $invalidMsgJson;
}
