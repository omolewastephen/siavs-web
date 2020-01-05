<?php
require('init.php');
$school = $db->single("SELECT * FROM schools ");
$from = $_GET['from'];
$to = $_GET['to'];
$card = $_GET['card'];
$card = $_GET['card'];
$terminal = $_GET['terminal'];

if($terminal == 'all' && $card == 'all'){
    $sql = "SELECT * FROM logs WHERE (log_date BETWEEN '{$from}' AND '{$to}' )";
    $data = $db->resultset($sql);
}elseif($terminal == 'all'){
    $sqlPerson = "SELECT surname,other_name FROM students WHERE cardnum = '{$card}'   ";
    $personData = $db->single($sqlPerson);
    $sql = "SELECT * FROM logs WHERE (log_date BETWEEN '{$from}' AND '{$to}' ) AND cardnum = '{$card}' ";
    $data = $db->resultset($sql);
  }elseif($card == 'all'){
     $sqlPerson = "SELECT surname,other_name FROM students WHERE cardnum = '{$card}'   ";
    $personData = $db->single($sqlPerson);
    $sql = "SELECT * FROM logs WHERE (log_date BETWEEN '{$from}' AND '{$to}' ) AND location = '{$terminal}' ";
    $data = $db->resultset($sql);
  }else{
    $sqlPerson = "SELECT surname,other_name FROM students WHERE cardnum = '{$card}' ";
    $personData = $db->single($sqlPerson);
    $sql = "SELECT * FROM logs WHERE (log_date BETWEEN '{$from}' AND '{$to}' ) AND cardnum = '{$card}' AND location = '{$terminal}'";
    $data = $db->resultset($sql);
  }
   
    


?>
<html>
  <head>
    <title>SIAVS | Report</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/css/custom.css"/>
    <link rel="stylesheet" href="assets/css/animate.css"/>
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"/>
    <style>
      .logo{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        vertical-align: middle;
        padding: 20px;
      }
      td,th{
        text-align: center;
      }
    </style>
  </head>
  <body>
<div class="container mt-5">
  <div class="logo" style="height: 150px;border:2px dashed #000 ">
    <div><img height="100" width="100" class="d-block" src="<?php echo $school->school_logo ?>"></div>
    <div style="font-size: 30px;text-transform:uppercase;margin-top: 20px;font-weight: bold"><?php echo $school->school_name; ?>
      <br><br>
     <small style="font-size: 15px;margin-top: 5px;text-transform: uppercase;"><?php echo $school->school_address; ?></small>
    </div>
  </div>
</div>
<hr>
<div class="container">
	<div class="row mt-2">
    <div class="col-lg-12">
      <div>
        <div style="text-decoration: underline;font-size:20px;margin-top: 10px;margin-bottom:20px;text-align:center;font-weight: bold">STUDENT IDENTITY AND ATTENDANCE VERIFICATION SYSTEM</div>
        <div class="row">
          <div class="col" style="font-size:18px;margin-top: 5px;margin-bottom:9px">Report From: <b><?php echo date('d M,Y',strtotime($_GET['from'])); ?></b> To <b><?php echo date('d M,Y',strtotime($_GET['to'])); ?></b>
          </div>
          <div class="col" style="font-size:18px;margin-top: 5px;margin-bottom:9px;text-align: right">
           <?php if(isset($data[0])){ ?>
           Student: <?php echo ($card == 'all')? '<b>ALL STUDENT</b>': '<b>'.strtoupper($data[0]->student_name).'</b>'; ?> | Terminal: <b><?php echo strtoupper($_GET['terminal']); ?></b>
         <?php }else{ ?>
            Student: <?php echo ($card == 'all')? '<b>ALL STUDENT</b>': '<b>'.strtoupper($personData->surname . " " . $personData->other_name).'</b>'; ?> | Terminal: <b><?php echo strtoupper($_GET['terminal']); ?></b>
         <?php  } ?>
          </div>
       </div>
      </div>
      </div>
  	   <div class="table-responsive">
        <table class="table table-bordered table-striped" id="dataTable">
         
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Card Number</th>
              <th scope="col">Usage Type</th>
              <th scope="col">Location</th>
            
              <th scope="col">Date</th>
              <th scope="col">Time</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $count = $db->rowcount();
              if($count > 0){
                $i = 1;
                foreach($data as $log){
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $log->cardnum; ?></td>
                <td><?php echo ($log->type == 'Arrival')? "Arrival":"Departure" ; ?></td>
                <td><?php echo $log->location;  ?></td>
             
                <td><?php echo date('d M, Y',strtotime($log->log_date)); ?></td>
                <td><?php echo $log->log_time; ?></td>
              </tr>
            <?php  $i++; } } ?>
          </tbody>
        </table>
      </div>
    </div>
	</div>
</div>

