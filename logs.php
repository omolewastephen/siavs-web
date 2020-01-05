<?php
require('init.php');
include 'template/header.php';
?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-edit"></span> STUDENT CARD LOGS
          <a href="report.php" class="btn btn-md btn-warning float-right"><i class="fa fa-list"></i> Generate Report</a>
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>

  <div class="row mt-3">
    <div class="table-responsive">
      <table class="table" id="dataTable">
        <caption>List of registered students</caption>
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Card Number</th>
            <th scope="col">Student Name</th>
            <th scope="col">Usage Type</th>
            <th scope="col">Location Used</th>
            <th scope="col">Date<small>(dd/mm/YYYY)</small></th>
            <th scope="col">Time</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $logs = $db->resultset("SELECT * FROM logs ORDER BY id DESC");
            $count = $db->rowcount();
            if($count > 0){
              $i = 1;
              foreach($logs as $log){
          ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $log->cardnum; ?></td>
              <td><?php echo $log->student_name; ?></td>
              <td><?php echo ($log->type == 'Arrival')? "<span class='badge badge-success'>Arrival</span>":"<span class='badge badge-danger'>Departure</span>" ; ?></td>
              <td><?php echo ($log->location) ?></td>
              <td><?php echo date("d/m/Y", strtotime($log->log_date)); ?></td>
              <td><?php echo $log->log_time; ?></td>
            </tr>
          <?php  $i++; } } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
