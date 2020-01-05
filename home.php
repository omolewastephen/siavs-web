<?php
require('init.php');
include 'template/header.php';
?>
<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
      <h3 class="page-header pb-3"><span class="fa fa-list-alt"></span> MENU </h3>
      <div class="menu-wrapper d-block mt-4">
        <ul class="menu">
          <li>
            <a href="std.php">
              <div class="content mx-auto d-block mt-3">
                <img src="images/Students-icon.png" height="100" width="100" class="mx-auto d-block img-fluid">
                <p class='mt-2'>Students</p>
              </div>
            </a>
          </li>

          <li>
            <a href="school.php">
              <div class="content mx-auto d-block mt-3">
                <img src="images/school-icon.png" height="100" width="100" class="mx-auto d-block img-fluid">
                <p class='mt-2'>School</p>
              </div>
            </a>
          </li>

          <li>
            <a href="logs.php">
              <div class="content mx-auto d-block mt-3">
                <img src="images/Log-icon.png" height="100" width="100" class="mx-auto d-block img-fluid">
                <p class='mt-2'>Logs</p>
              </div>
            </a>
          </li>

          <li>
            <a href="sms.php">
              <div class="content mx-auto d-block mt-3">
                <img src="images/sms-icon.png" height="100" width="100" class="mx-auto d-block img-fluid">
                <p class='mt-2'>SMS Settings</p>
              </div>
            </a>
          </li>

          <li>
            <a href="settings.php">
              <div class="content mx-auto d-block mt-3">
                <img src="images/Settings-icon.png" height="100" width="100" class="mx-auto d-block img-fluid">
                <p class='mt-2'>Admin Settings</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
      <h3 class="page-header pb-3"><span class="fa fa-server"></span> SERVER DETAILS </h3>
      <ul class="server-list list-inline" type="none" style="padding:0">
        <li>SOFTWARE SERVER:<p> <?php echo $_SERVER['SERVER_SOFTWARE'] ?> </p></li>
        <li>LOCAL ADDRESS:
          <p>
            <?php 
            $myIp = getHostByName(php_uname('n'));
            echo $myIp;
            ?>
          </p>
        </li>
        <li>SERVER NAME:<p> <?php echo $_SERVER['SERVER_NAME'] ?> </p></li>
        <li>BROSWER INFO:<p> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </p></li>
      </ul>
    </div>
  </div>
</div>
<?php include 'template/footer.php'; ?>
