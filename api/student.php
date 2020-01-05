<?php
date_default_timezone_set('Africa/Lagos');
require('../init.php');
$json = file_get_contents("php://input");
$obj = json_decode($json,true);


$card = $obj['cardnum'];
$type = $obj['type'];

$checkifExist = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' ");
$countIfExist = $db->rowcount();
if($countIfExist == 1){

	if($type == 'Arrival'){

			$stmt = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' "); // Get Student details

			/** SMS API  **/

			$arrivalmessage =  $db->single_assoc("SELECT * from message");
			$arrival = $arrivalmessage['arrival'];
			$sender = $arrivalmessage['Sender'];
			$api_username = trim($arrivalmessage['api_username']);
			$api_password = trim($arrivalmessage['api_password']);

			/** SMS API  **/

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
				"log_time" => $time
			);
			$ifLogged =  $db->single_assoc("SELECT * FROM logs WHERE cardnum = '{$card}' AND type = '{$type}' AND log_date = '{$date}' ");
			$loggedFound = $db->rowcount();

			if($loggedFound == 1){
				$successLoginMsg = 1;
				$successLoginJson = json_encode($successLoginMsg);
				$param = array(
					'message' => 3
				);
				
				echo json_encode($param);

			}else{


				if($count > 0){
					$db->insert('logs',$log);
					$successLoginMsg = 1;
					$successLoginJson = json_encode($successLoginMsg);
					$param = array(
						'message' => 1,
						'data' => $stmt
					);
					if(sendmessage($arrival,$phone,$sender,$parent,$student_name,$api_username,$api_password)){
						echo json_encode($param);
					}else{
						echo json_encode($param);
					}
					
				}else{
					$invalidMsg = 0;
					$invalidMsgJson = json_encode($invalidMsg);
					echo $invalidMsgJson;
			   }

			}
		}elseif($type == 'Departure') {
			$stmt = $db->single_assoc("SELECT * FROM students WHERE cardnum = '{$card}' "); //Get student

			/** SMS API  **/

			$departuremessage =  $db->single_assoc("SELECT * from message");
			$departure = $departuremessage['departure'];
			$sender = $departuremessage['Sender'];
			$api_username = trim($departuremessage['api_username']);
			$api_password = trim($departuremessage['api_password']);

			/** SMS API  **/

			/** SCHOOL  **/

			$sch =  $db->single_assoc("SELECT * from schools");
			$school_name = $sch['school_name'];

			/** SCHOOL  **/
			$count = $db->rowcount();

			$date = date('Y-m-d');
			$time = date('h:i:s');
			$student_name = $stmt['surname'] . " ". $stmt['other_name'];
			$parent = $stmt['parent'];
			$phone = $stmt['phone'];

			$log = array(
				"cardnum" => $card,
				"student_name" => $student_name,
				"type" => $type,
				"log_date" => $date,
				"log_time" => $time
			);
			$ifLogged =  $db->single_assoc("SELECT * FROM logs WHERE cardnum = '{$card}' AND type = '{$type}' AND log_date = '{$date}' ");
			$loggedFound = $db->rowcount();

			if($loggedFound == 1){

				$successLoginMsg = 1;
				$successLoginJson = json_encode($successLoginMsg);
				$param = array(
					'message' => 3
				);
				echo json_encode($param);

			}else{


				if($count > 0){
					$db->insert('logs',$log);
					$successLoginMsg = 1;
					$successLoginJson = json_encode($successLoginMsg);
					$param = array(
						'message' => 1,
						'data' => $stmt
					);
					if(sendmessage($departure,$phone,$sender,$parent,$student_name,$api_username,$api_password)){
						echo json_encode($param);
					}else{
						echo json_encode($param);
					}
					
				}else{
					$invalidMsg = 0;
					$invalidMsgJson = json_encode($invalidMsg);
					echo $invalidMsgJson;
			   }

			}

		}else{
			// DO nothing
		}

}else{
	$param = array(
			'message' => 4
		);
				
	echo json_encode($param);

}



