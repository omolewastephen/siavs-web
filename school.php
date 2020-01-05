<?php
require('init.php');
include 'template/header.php';
$school = $db->single("SELECT * FROM schools ");
$id = $school->id;
if(isset($_POST['update'])){
  $school_name = $_POST['school_name'];
  $school_address = $_POST['school_address'];
  if(!empty($_FILES['p2']['name'])){
    if(file_exists(getcwd()."/".$school->school_logo)){
      unlink(getcwd()."/".$school->school_logo);
    }
		$imgType = array('image/jpg', 'image/png', 'image/jpeg', 'image/bmp','image/gif');
		$imageUpload = new FileUpload('uploads/school/', $imgType, 5, 'mb');
		list($status, $school_logo) = $imageUpload->uploadSingleFile('p2');
	}else{
    $school_logo = $school->school_logo;
  }

  $data = array(
    'school_name' => $school_name,
    'school_logo' => $school_logo,
    'school_address' => $school_address
  );

  if($db->update('schools',$data,$id)){
    $success = notification('School info updated.','success');
  }else{
    $error = notification('Error updating school info.','danger');
  }
}
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-university"></span> SCHOOL SETTING
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
        <?php if(!empty($error)){ echo $error; header('refresh: 2'); } ?>
        <?php if(!empty($success)){ echo $success; header('refresh: 2'); } ?>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-md-8 col-lg-8">
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>School Name:</label>
          <input type="text" class="form-control" name="school_name" value="<?php echo $school->school_name ?>" />
        </div>

        <div class="form-group">
          <label>School Address:</label>
          <input type="text" class="form-control" name="school_address" value="<?php echo $school->school_address; ?>" />
        </div>

        <div class="form-group ">
          <div style="width:100px;height:100px">
            <img src="<?php echo $school->school_logo ?>" id="preview2" alt="LOGO" width="100" height="100" />
          </div>
          <label>School Logo:</label>
          <input type="file" class="form-control" id="p2" name="p2" value="<?php ?>" />
        </div>

        <button type="submit" name="update" class="btn btn-warning btn-md"> Update</button>
        <button type="reset" name="update" class="btn btn-danger btn-md"> Cancel</button>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
