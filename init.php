<?php
session_start();
spl_autoload_register(function($class){
  require "classes/".$class.".php";
});
require('function.php');
?>
