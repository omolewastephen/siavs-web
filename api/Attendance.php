<?php
date_default_timezone_set('Africa/Lagos');
require('../init.php');
$json = file_get_contents("php://input");
$obj = json_decode($json,true);

$card = $obj['cardnum'];
$location = $obj['location'];
$type = $obj['type'];

// Get Student using card
$stmt = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' ");
$if_card_exist = $db->rowcount();
if($if_card_exist == 0){
	$invalidMsg = 0;
	$invalidMsgJson = json_encode($invalidMsg);
    echo $invalidMsgJson;
    exit();
}
$student_type = $stmt['std_type'];
$date = date('Y-m-d');
$time = date('h:i:s');
$student_name = $stmt['surname'] . " ". $stmt['other_name'];
$phone = $stmt['phone'];
$parent = $stmt['parent'];


// Get SMS status
$is_sms_enabled = $db->sms_status('g');
$is_day_arr_sms_enabled = $db->sms_status('das');
$is_day_dep_sms_enabled = $db->sms_status('dds');
$is_b_arr_sms_enabled = $db->sms_status('bas');
$is_b_dep_sms_enabled = $db->sms_status('bds');

// SMS Contents
$message =  $db->single_assoc("SELECT * from message");
$arrival = $message['arrival'];
$departure = $message['departure'];
$sender = $message['Sender'];
$api_username = trim($message['api_username']);
$api_password = trim($message['api_password']);

// School Data
$sch =  $db->single_assoc("SELECT * from schools");
$school_name = $sch['school_name'];

// Check if logged
$ifLogged =  $db->single_assoc("SELECT * FROM logs WHERE cardnum = '{$card}' AND type = '{$type}' AND log_date = '{$date}' ");
$loggedFound = $db->rowcount();

if($location === 'School Gate' || $location === 'Hostel'){


if($student_type == 'Day' && $type == 'Arrival'){

	if($if_card_exist > 0){
		$log = array(
			"cardnum" => $card,
			"student_name" => $student_name,
			"type" => $type,
			"location"=> $location,
			"log_date" => $date,
			"log_time" => $time
		);

		if($loggedFound == 1){
			$successLoginMsg = 1;
			$successLoginJson = json_encode($successLoginMsg);
			$param = array(
				'message' => 3
			);
			echo json_encode($param);

		}else{
			$db->insert('logs',$log);
			$param = array(
				'message' => 1,
				'data' => $stmt
			);
			if($is_sms_enabled == 1 && $is_day_arr_sms_enabled == 1){
				sendmessage($arrival,$phone,$sender,$parent,$student_name,$api_username,$api_password,$student_type,$type);
				echo json_encode($param);
			}elseif($is_sms_enabled == 1 && $is_day_arr_sms_enabled == 0){
				echo json_encode($param);
			}elseif($is_sms_enabled == 0 && $is_day_arr_sms_enabled == 1){
				echo json_encode($param);
			}else{
				echo json_encode($param);
			}
		}
		
		
	}else{
		$invalidMsg = 0;
		$invalidMsgJson = json_encode($invalidMsg);
		echo $invalidMsgJson;
	}

}elseif ($student_type == 'Day' && $type == 'Departure') {
	if($if_card_exist > 0){
		$log = array(
			"cardnum" => $card,
			"student_name" => $student_name,
			"type" => $type,
			"location"=> $location,
			"log_date" => $date,
			"log_time" => $time
		);
		if($loggedFound == 1){
			$successLoginMsg = 1;
			$successLoginJson = json_encode($successLoginMsg);
			$param = array(
				'message' => 3
			);
			echo json_encode($param);

		}else{
			$db->insert('logs',$log);
			$param = array(
				'message' => 1,
				'data' => $stmt
			);
			if($is_sms_enabled == 1 && $is_day_dep_sms_enabled == 1){
				sendmessage($departure,$phone,$sender,$parent,$student_name,$api_username,$api_password,$student_type,$type);
				echo json_encode($param);
			}elseif($is_sms_enabled == 1 && $is_day_dep_sms_enabled == 0){
				echo json_encode($param);
			}elseif($is_sms_enabled == 0 && $is_day_dep_sms_enabled == 1){
				echo json_encode($param);
			}else{
				echo json_encode($param);
			}
		}
		
	}else{
		$invalidMsg = 0;
		$invalidMsgJson = json_encode($invalidMsg);
		echo $invalidMsgJson;
	}
}elseif ($student_type == 'Boarding' && $type == 'Arrival') {
		if($if_card_exist > 0){
		$log = array(
			"cardnum" => $card,
			"student_name" => $student_name,
			"type" => $type,
			"location"=> $location,
			"log_date" => $date,
			"log_time" => $time
		);
		if($loggedFound == 1){
			$successLoginMsg = 1;
			$successLoginJson = json_encode($successLoginMsg);
			$param = array(
				'message' => 3
			);
			echo json_encode($param);

		}else{
			$db->insert('logs',$log);
			$param = array(
				'message' => 1,
				'data' => $stmt
			);
			if($is_sms_enabled == 1 && $is_b_arr_sms_enabled == 1){
				sendmessage($arrival,$phone,$sender,$parent,$student_name,$api_username,$api_password,$student_type,$type);
				echo json_encode($param);
			}elseif($is_sms_enabled == 1 && $is_b_arr_sms_enabled == 0){
				echo json_encode($param);
			}elseif($is_sms_enabled == 0 && $is_b_arr_sms_enabled == 1){
				echo json_encode($param);
			}else{
				echo json_encode($param);
			}
		}
		
	}else{
		$invalidMsg = 0;
		$invalidMsgJson = json_encode($invalidMsg);
		echo $invalidMsgJson;
	}
}elseif ($student_type == 'Boarding' && $type == 'Departure') {
	if($if_card_exist > 0){
		$log = array(
			"cardnum" => $card,
			"student_name" => $student_name,
			"type" => $type,
			"location"=> $location,
			"log_date" => $date,
			"log_time" => $time
		);
		if($loggedFound == 1){
			$successLoginMsg = 1;
			$successLoginJson = json_encode($successLoginMsg);
			$param = array(
				'message' => 3
			);
			echo json_encode($param);

		}else{
			$db->insert('logs',$log);
			$param = array(
				'message' => 1,
				'data' => $stmt
			);
			if($is_sms_enabled == 1 && $is_b_dep_sms_enabled == 1){
				sendmessage($departure,$phone,$sender,$parent,$student_name,$api_username,$api_password,$student_type,$type);
				echo json_encode($param);
			}elseif($is_sms_enabled == 1 && $is_b_dep_sms_enabled == 0){
				echo json_encode($param);
			}elseif($is_sms_enabled == 0 && $is_b_dep_sms_enabled == 1){
				echo json_encode($param);
			}else{
				echo json_encode($param);
			}
		}
		
	}else{
		$invalidMsg = 0;
		$invalidMsgJson = json_encode($invalidMsg);
		echo $invalidMsgJson;
	}
}


}
else{
	if($if_card_exist > 0){
		$log = array(
			"cardnum" => $card,
			"student_name" => $student_name,
			"type" => $type,
			"location"=> $location,
			"log_date" => $date,
			"log_time" => $time
		);
		$db->insert('logs',$log);
		$param = array(
			'message' => 1,
			'data' => $stmt
		);

		echo json_encode($param);
	}
	
}
