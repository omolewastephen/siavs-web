<?php
require('init.php');
include 'template/header.php';
$success = $error = "";
if(isset($_GET['success']) AND !empty($_GET['success']))
{
  $code = $_GET['success'];
  if($code == 1){
    $success = notification('Deleted successfully','success');
  }elseif ($code == 0) {
    $error = notification('Error deleting records','danger');
  }else{
    // Do nothing
  }
}
?>
<style>
  table td{
    text-align: center;
  }
</style>
<div class="container-fluid">
  <div class="row mt-5 mb-3">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-users"></span> REGISTERED STUDENTS
          <a href="add.php" class="btn btn-md btn-warning float-right"><i class="fa fa-plus-circle"></i> Add new student</a>
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-md-12 col-lg-12">
      <?php if(!empty($error)){ echo $error; header('location: std.php'); } ?>
      <?php if(!empty($success)){ echo $success; header('location: std.php'); } ?>
      <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered" id="dataTable">
          <caption>List of registered students</caption>
          <thead>
            <tr class="text-center" style="font-size:14px;">
              <th scope="col">ID</th>
              <th scope="col">Admission No</th>
              <th scope="col">Photo</th>
              <th scope="col">Card</th>
              <th scope="col">Surname</th>
              <th scope="col">Other</th>
              <th scope="col">Sex</th>
              <th scope="col">Class</th>
              <th scope="col">Student Type</th>
              <th scope="col">Fees Status</th>
              <th scope="col">Date Registered</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $students = $db->resultset("SELECT * FROM students");
              $count = $db->rowcount();
              if($count > 0){
                $i = 1;
                foreach($students as $student){
            ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $student->adm_no; ?></td>
                  <td><img height="40" width="40" class="thumbnail" src="<?php echo $student->std_img; ?>"/></td>
                  <td><?php echo $student->cardnum; ?></td>
                  <td><?php echo $student->surname; ?></td>
                  <td><?php echo $student->other_name; ?></td>
                  <td><?php echo $student->gender; ?></td>
                  <td><?php echo $student->class; ?></td>
                  <td><?php echo $student->std_type; ?></td>
                  <td><?php echo $student->sch_fees_status; ?></td>
                  <td><?php echo $student->date_reg; ?></td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wrench"></i> Action
                      </button>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="edit.php?id=<?php echo $student->id; ?>">Edit</a>
                          <a class="dropdown-item" onclick="return confirm('Do you want to delete student record? \n \n \n Note that all records pertaining to this student will be deleted.')" href="delete.php?id=<?php echo $student->id; ?>">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
            <?php $i++; }
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
