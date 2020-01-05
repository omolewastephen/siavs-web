<?php
if(!$_SESSION['sess_id'] OR $_SESSION['sess_id'] == '' OR empty($_SESSION['sess_id'])){
  redirect('index.php');
}
$school = $db->single("SELECT * FROM schools ");
 ?>
<html>
  <head>
    <title>SIAVS | Admin Panel</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/css/custom.css"/>
    <link rel="stylesheet" href="assets/css/animate.css"/>
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"/>
  </head>
  <body class="home-page">
    <div class="container-fluid no-gutters" style="padding: 0px;">
	  <nav class="navbar sticky-top navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand-xs navbar-light shadow bg-whit bg-light">
    <a class="navbar-brand" href="home.php">
      <img src="<?php echo (!empty($school->school_logo)) ? $school->school_logo: 'images/icon.png'; ?>" width="50" height="50" alt="APP LOGO ">
      <h3 class="d-inline bold icon"><?php echo (!empty(@$school->school_name)) ? @$school->school_name: 'SIAVS V1.0'; ?> <small style="font-size:13px">Administrator Panel</small></h3>
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="logout.php" onclick="return confirm('Do you want to end to log out? \n \n Press Ok to continue')" style="color:white" class="btn btn-danger btn-md nav-link"><span style="color:white" class="fa fa-power-off"></span> Log out </a>
      </li>
    </ul>

    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">

	   </div> -->
	  </nav>
  </div>
