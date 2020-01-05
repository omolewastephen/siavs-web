<?php
require('init.php');
$result = array();

if(isset($_GET['cardNum']) AND !empty($_GET['cardNum'])){
  $cardnum = $_GET['cardNum'];
  $student = $db->single_assoc("SELECT * FROM students WHERE card = '{$cardnum}' LIMIT 1 ");
  $count = $db->rowcount();
  if($count > 0){
    $temp['status'] = true;
    $temp['surname'] = $student['surname'];
    $temp['other_name'] = $student['other_name'];
    $temp['cardnum'] = $student['cardnum'];
    $temp['parent'] = $student['parent'];
    $temp['gender'] = $student['gender'];
    $temp['class'] = $student['class'];
    $temp['sch_fees_status'] = $student['sch_fees_status'];
    $temp['std_img'] = $student['std_img'];
    $temp['phone'] = $student['phone'];
    $temp['address'] = $student['address'];
    $temp['parentOne_img'] = $student['parentOne_img'];
    $temp['parentTwo_img'] = $student['parentTwo_img'];
    $temp['parentThree_img'] = $student['parentThree_img'];
    $temp['parentFour_img'] = $student['parentFour_img'];
    $temp['parentFive_img'] = $student['parentFive_img'];

    // INSERT INTO Logs
    $savetoLog = array(
      'cardnum' => $student['cardnum'],
      'student_name' => $student['surname']." ". $student['other_name'],
      'type' => 'arrival',
      'log_date' => date('Y-m-d'),
      'log_time' => date('h:i:s')
    );
    $db->insert('logs',$savetoLog);

    array_push($result,$temps);
  }else{
    $temp['status'] = "false";
	  array_push($result, $temps);
  }

  echo json_encode($result);
}
