<?php
require('init.php');
$school = $db->single("SELECT * FROM schools");
$count = $db->rowcount();
if($count == 1){
  $school_name = $school->school_name;
  $school_logo = $school->school_logo;
}
if(isset($_POST['submit'])){
  $username = clean($_POST['username']);
  $password = $_POST['password'];

  if(if_exist($username,$password)){
    login($username,$password);
  }else{
    $error = notification('Invalid login credentials','danger');
  }
}
?>
<html>
  <head>
    <title><?php echo (!empty(@$school_name)) ? @$school_name: 'SIAVS'; ?> | Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/custom.css"/>
    <link rel="stylesheet" href="assets/css/animate.css"/>
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="assets/css/pnotify.custom.min.css"/>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"/>
  </head>
  <body class="login-page">
    <div class="container h-100 ">
      <div class="row align-items-center h-100">
        <div class="col-md-5 col-xs-12 col-lg-5 col-sm-5  mx-auto">
          	<?php if(!empty($error)){ echo $error; } ?>
          <div class="logo-wrap">
    				<img src="<?php echo (!empty($school->school_logo)) ? $school->school_logo: 'images/icon.png'; ?>" class="img-fluid d-block mx-auto" height="100" width="100">
    				<h2 class="text-center bold" style="text-transform: uppercase;"><?php echo (!empty(@$school_name)) ? @$school_name: 'SIVS SOLUTION'; ?></h2>
            <h4 class="text-center bold">STUDENT IDENTITY AND ATTENDANCE VERIFICATION SYSTEM</h4>
    			</div>
    			<p class="text-center">Login to your account</p>

    			<form method="post" autocomplete="off">
    				<div class="input-group mb-3">
    				  <div class="input-group-prepend">
    				    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user icon"></i></span>
    				  </div>
    				  <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
    				</div>

    				<div class="input-group mb-3">
    				  <div class="input-group-prepend">
    				    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock icon"></i></span>
    				  </div>
    				  <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
    				</div>

    				 <button type="submit" name="submit" class="btn btn-block btn-warning">Submit</button>
    			</form>

          <div class="mt-5 text-center mx-auto">
    				<p>POWERED BY TOP-TECHNOLOGIES</p>
    			</div>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/pnotify.custom.min.js"></script>
  </body>
</html>
