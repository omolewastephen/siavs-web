<?php
require('init.php');
include 'template/header.php';

if (isset($_POST['submitbtn'])) {
  $surname = clean($_POST['surname']);
  $other_name = clean($_POST['other_name']);
  $class = clean($_POST['class']);
  $gender = clean($_POST['gender']);
  $cardnum = clean($_POST['cardnum']);
  $phone = clean($_POST['phone']);
  $parent = clean($_POST['parent']);
  $address = clean($_POST['address']);
  $std_type = clean($_POST['std_type']);
  $adm_no = clean($_POST['adm_no']);
  $sch_fees_status = clean($_POST['sch_fees_status']);
  $date_reg = date('Y-m-d');

  if(!empty($_FILES['stdimg']['name'])){
		$imgType = array('image/jpg', 'image/png', 'image/jpeg', 'image/bmp');
		$imageUpload = new FileUpload('uploads/student/', $imgType, 5, 'mb');
		list($status, $studentPic) = $imageUpload->uploadSingleFile('stdimg');
	}

  $data = array(
    'surname' => $surname,
    'other_name' => $other_name,
    'cardnum' => $cardnum,
    'gender' => $gender,
    'class' => $class,
    'sch_fees_status' => $sch_fees_status,
    'std_img' => $studentPic,
    'phone' => $phone,
    'address' => $address,
    'date_reg' => $date_reg,
    'adm_no' =>$adm_no,
    'std_type' => $std_type,
    'parent' =>$parent
  );

  if( $db->insert('students',$data) ){
    $success = notification('Student added successfully','success');
  }else{
    $error = notification('Error adding student data','danger');
  }

}
?>

<div class="container">
  <div class="row mt-3 mb-3">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-users"></span> ADD NEW STUDENT
          <a href="std.php" class="btn btn-md btn-warning float-right"><i class="fa fa-list"></i> Registered Students</a>
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-md-12 col-lg-12">
      <?php if(!empty($error)){ echo $error; } ?>
      <?php if(!empty($success)){ echo $success; } ?>
      <form method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Surname:</label>
            <input type="text" class="form-control" name="surname" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Other Names:</label>
            <input type="text" class="form-control" name="other_name" required/>
          </div>
          <div class="form-group col-lg-4 col-md-4">
            <label>Card Number:</label>
            <input type="text" class="form-control" name="cardnum" required/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-lg-4 col-md-4">
            <label>Parents:</label>
            <input type="text" class="form-control" name="parent" placeholder="Mr/Mrs John Doe" required/>
          </div>
          <div class="form-group col-lg-4 col-md-4">
            <label>Home Address:</label>
            <input type="text" class="form-control" name="address" required/>
          </div>
          <div class="form-group col-lg-4 col-md-4">
            <label>Phone Number:</label>
            <input type="text" class="form-control" placeholder="+234XXXXXXXXXXXX" name="phone" required/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Gender:</label>
            <select class="form-control" name="gender" required>
              <option value="">--Choose--</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Class:</label>
            <input type="text" class="form-control" name="class" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>School Fees Status:</label>
            <select class="form-control" name="sch_fees_status" required>
              <option value="">--Choose--</option>
              <option value="Not Paid">Not Paid</option>
              <option value="Paid">Paid</option>
              <option value="Incomplete">Incomplete</option>
            </select>
          </div>
         </div>

         <div class="row">
          <div class="form-group col-md-4 col-lg-4">
             <label>Admission Number:</label>
             <input type="text" class="form-control" name="adm_no" required/>
           </div>
           <div class="form-group col-md-4 col-lg-4">
             <label>Student Type:</label>
             <select class="form-control" name="std_type">
               <option value="" selected>--Choose Type--</option>
               <option value="Day">Day</option>
               <option value="Boarding">Boarding</option>
             </select>
           </div>
           <div class="form-group col-md-4 col-lg-4">
             <label>Student Image:</label>
             <input type="file" class="form-control" name="stdimg" required/>
           </div>
         </div>


         <button type="submit" name="submitbtn" class="btn btn-md btn-warning">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
