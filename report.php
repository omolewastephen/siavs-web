<?php
require('init.php');
include 'template/header.php';
$student = $db->resultset("SELECT surname,other_name,cardnum FROM students");
if(isset($_POST['submit'])){
  $from = $_POST['from'];
  $to = $_POST['to'];
  $card = $_POST['card'];
  $location = $_POST['location'];

  if($card == 'all'){
    redirect('print.php?from='.$from."&to=".$to."&card=all&terminal=".$location);
  }else{
    redirect('print.php?from='.$from."&to=".$to."&card=".$card."&terminal=".$location);
  }

  
}
?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-edit"></span> GENERATE REPORT 
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-8 col-lg-8">
      <form method="post">
        <div class="form-group">
          <label>Student Name</label>
          <select name="card" class="form-control" required>
            <option value="" selected>Select Student</option>
            <option value="all">All Student</option>
            <?php foreach($student as $std): ?>
              <option value="<?php echo $std->cardnum ?>"> <?php echo $std->surname." ". $std->other_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Terminal Location</label>
          <select name="location" class="form-control" required>
          <option value="" selected>Choose Terminal Location</option>
          <option value="all">All Location</option>
          <?php foreach($db->getUsedLocation() as $location): ?>
            <option value="<?php echo $location->location; ?>"><?php echo $location->location; ?></option>
          <?php endforeach; ?>
         </select>
        </div>
        <div class="form-group">
          <label>From</label>
          <input type="date" class="form-control" name="from" required>
        </div>
        <div class="form-group">
          <label>To</label>
          <input type="date" class="form-control" name="to" required>
        </div>

        <button name="submit" type="submit" class="btn btn-md btn-dark">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
