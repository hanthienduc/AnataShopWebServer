<?php
  define("DBSERVER", "mysql.hostinger.vn");
  define("DBUSERNAME","u604749631_duc");
  define("DBPASSWORD","hanthienduc");
  define("DBNAME","u604749631_duc");

  date_default_timezone_set("Asia/Ho_Chi_Minh");

  $conn = mysqli_connect(DBSERVER,DBUSERNAME,DBPASSWORD,DBNAME);
  //$conn->set_charset("utf8");
  if(!$conn){
    die('Connect Error: '.mysqli_connect_errno());
  }
 ?>
