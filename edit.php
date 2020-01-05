<?php
require('init.php');
include 'template/header.php';
$success = $error = "";
if(isset($_GET['id']) AND !empty($_GET['id'])){
  $id = (int)$_GET['id'];
  $student = $db->single("SELECT * FROM students WHERE id = '{$id}' ");
}
if (isset($_POST['updatebtn'])) {
  $surname = clean($_POST['surname']);
  $other_name = clean($_POST['other_name']);
  $class = clean($_POST['class']);
  $gender = clean($_POST['gender']);
  $cardnum = clean($_POST['cardnum']);
  $sch_fees_status = clean($_POST['sch_fees_status']);
  $phone = clean($_POST['phone']);
  $parent = clean($_POST['parent']);
  $address = clean($_POST['address']);
  $std_type = clean($_POST['std_type']);
  $adm_no = clean($_POST['adm_no']);

  if(!empty($_FILES['stdimg']['name'])){
    if(file_exists(getcwd()."/".$student->std_img)){
      unlink(getcwd()."/".$student->std_img);
    }
		$imgType = array('image/jpg', 'image/png', 'image/jpeg', 'image/bmp');
		$imageUpload = new FileUpload('uploads/student/', $imgType, 5, 'mb');
		list($status, $studentPic) = $imageUpload->uploadSingleFile('stdimg');
	}else{
    $studentPic = $student->std_img;
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
    'parent' => $parent,
    'adm_no' =>$adm_no,
    'std_type' => $std_type,
  );

  if( $db->update('students',$data,$id) ){
    $success = notification('Student information updated successfully','success');
  }else{
    print_r($db->update('students',$data,$id));
    $error = notification('Error updating student data. Try Again','danger');
  }

}
?>

<div class="container">
  <div class="row mt-3 mb-3">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-users"></span> EDIT STUDENT DATA
          <a href="std.php" class="btn btn-md btn-warning float-right"><i class="fa fa-list"></i> Registered Students</a>
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-md-8 col-lg-8">
      <?php if(!empty($error)){ echo $error; header('refresh: 2'); } ?>
      <?php if(!empty($success)){ echo $success; header('refresh: 2'); } ?>
      <form method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Surname:</label>
            <input type="text" class="form-control" value="<?php echo $student->surname; ?>" name="surname" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Other Names:</label>
            <input type="text" class="form-control" value="<?php echo $student->other_name; ?>" name="other_name" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Card Number:</label>
            <input type="text" value="<?php echo $student->cardnum; ?>" class="form-control" name="cardnum" required/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-lg-4 col-md-4">
            <label>Parents:</label>
            <input type="text" class="form-control" value="<?php echo $student->parent; ?>" name="parent" placeholder="Mr & Mrs John Doe" required/>
          </div>
          <div class="form-group col-lg-4 col-md-4">
            <label>Home Address:</label>
            <input type="text" class="form-control" value="<?php echo $student->address; ?>" name="address" required/>
          </div>
          <div class="form-group col-lg-4 col-md-4">
            <label>Phone Number:</label>
            <input type="text" class="form-control" value="<?php echo $student->phone; ?>" placeholder="+234XXXXXXXXXXXX" name="phone" required/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Gender:</label>
            <select class="form-control" name="gender" required>
              <option value="<?php echo $student->gender; ?>"> <?php echo ($student->gender == 'M')? 'Male': 'Female'; ?> </option>
              <option value="">--Choose--</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Class:</label>
            <input type="text" value="<?php echo $student->class; ?>" class="form-control" name="class" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>School Fees Status:</label>
            <select class="form-control" name="sch_fees_status" required>
              <option value="<?php echo $student->sch_fees_status; ?>"><?php echo $student->sch_fees_status; ?></option>
              <option value="">--Choose--</option>
              <option value="Not Paid">Not Paid</option>
              <option value="Paid">Paid</option>
              <option value="Incomplete">Incomplete</option>
            </select>
          </div>
         </div>

         <div class="row">
           <div class="form-group col-md-10 col-lg-10">
             <label>Student Image:</label>
             <input type="file" class="form-control" id="p5" name="stdimg"/>
           </div>
           <div class="col-md-2 col-lg-2">
             <img src="<?php echo $student->std_img ?>" id="preview5" width="100" height="100"/>
           </div>
         </div>

        <div class="row">
          <div class="form-group col-lg-4 col-md-4">
            <label>Admission No:</label>
            <input type="text" class="form-control" value="<?php echo $student->adm_no; ?>" name="adm_no" required/>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Studentship:</label>
            <select class="form-control" name="std_type" required>
              <option value="<?php echo $student->std_type; ?>"> <?php echo $student->std_type; ?> </option>
              <option value="">--Choose--</option>
              <option value="Day">Day</option>
              <option value="Boarding">Boarding</option>
            </select>
          </div>
        </div>

         <button type="submit" name="updatebtn" class="btn btn-md btn-warning">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
