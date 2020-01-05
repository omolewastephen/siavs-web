<?php
  require('init.php');
  session_start();
  unset($_SESSION['sess_id']);
  redirect('index.php');
?>
