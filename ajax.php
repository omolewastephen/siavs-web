<?php
 require('init.php');

 if(isset($_POST['status'])){
 	$status = $_POST['status'];
 	switch ($status) {
 		case 1:
 			if($db->sms_global_controller(1,'g')){
 				$param = array(
 				 "message" => "TURN ON SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			
 			break;
 		case 0:
 			if($db->sms_global_controller(0,'g')){
 				$param = array(
 				 "message" => "TURN OFF SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			break;
 		
 	}
 }

 if(isset($_POST['day_arrival_sms'])){
 	$day_arrival_sms = $_POST['day_arrival_sms'];
 	switch ($day_arrival_sms) {
 		case 1:
 			if($db->sms_global_controller(1,'das')){
 				$param = array(
 				 "message" => "TURN ON SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			
 			break;
 		case 0:
 			if($db->sms_global_controller(0,'das')){
 				$param = array(
 				 "message" => "TURN OFF SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			break;
 		
 	}
 }

 if(isset($_POST['day_departure_sms'])){
 	$day_departure_sms = $_POST['day_departure_sms'];
 	switch ($day_departure_sms) {
 		case 1:
 			if($db->sms_global_controller(1,'dds')){
 				$param = array(
 				 "message" => "TURN ON SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			
 			break;
 		case 0:
 			if($db->sms_global_controller(0,'dds')){
 				$param = array(
 				 "message" => "TURN OFF SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			break;
 		
 	}
 }

 if(isset($_POST['board_arrival_sms'])){
 	$board_arrival_sms = $_POST['board_arrival_sms'];
 	switch ($board_arrival_sms) {
 		case 1:
 			if($db->sms_global_controller(1,'bas')){
 				$param = array(
 				 "message" => "TURN ON SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			
 			break;
 		case 0:
 			if($db->sms_global_controller(0,'bas')){
 				$param = array(
 				 "message" => "TURN OFF SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			break;
 		
 	}
 }

  if(isset($_POST['board_dept_sms'])){
 	$board_dept_sms = $_POST['board_dept_sms'];
 	switch ($board_dept_sms) {
 		case 1:
 			if($db->sms_global_controller(1,'bds')){
 				$param = array(
 				 "message" => "TURN ON SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			
 			break;
 		case 0:
 			if($db->sms_global_controller(0,'bds')){
 				$param = array(
 				 "message" => "TURN OFF SUCCESSFULLY"
 				);
 			    echo json_encode($param);
 			}else{
 				$param = array(
 				 "message" => "SYSTEM ERROR! Try again"
 				);
 			    echo json_encode($param);
 			}
 			break;
 		
 	}
 }