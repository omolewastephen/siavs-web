<?php
require('init.php');
include 'template/header.php';
$id = $_SESSION['sess_id'];
$success = $error = "";
$admin = $db->single("SELECT * FROM admin WHERE id = '{$id}' ");


if(isset($_POST['update'])){
  $username = clean($_POST['username']);
  $password = clean($_POST['password']);


  if(!empty($password)){
    $data = array(
      'username' => $username,
      'password' => $password
    );
    if($db->update('admin',$data,$id)){
      $success = notification('Updated Successfully','success');
    }else{
      $error = notification('Error updating setting','danger');
    }
  }else{
    $data = array(
      'username' => $username,
    );
    if($db->update('admin',$data,$id)){
      $success = notification('Updated Successfully','success');
    }else{
      $error = notification('Error updating setting','danger');
    }
  }

}
?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-cog"></span> ADMIN SETTINGS
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-md-6 col-lg-6">
      <?php if(!empty($error)){ echo $error; header('refresh: 2'); } ?>
      <?php if(!empty($success)){ echo $success; header('refresh: 2'); } ?>
      <form method="post" autocomplete="off">
        <div class="form-group">
          <label>Username:</label>
          <input type="text" class="form-control" name="username" value="<?php echo $admin->username; ?>" />
        </div>
        <div class="form-group">
          <label>Password:</label>
          <input type="password" id="password" class="form-control" name="password" />
        </div>
      
        
        <button class="btn btn-md btn-warning btn-block" name="update" type="submit">Update</button>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
