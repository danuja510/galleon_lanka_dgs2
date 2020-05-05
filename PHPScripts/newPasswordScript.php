<?php
session_start();
    if(isset($_POST['btnSubmit']))
  {
   $cpwd = $_POST['txtconPwd'];

   $con1 = mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con1)
    {
      die("cannot connect to DB server");
    }
    $sql1="UPDATE `employees` SET `password` = '".md5($cpwd)."' WHERE `employees`.`eno` = '".$_SESSION['reset']."'";
    mysqli_query($con1,$sql1);
    if(!isset($_SESSION['eno']))
    {
      $_SESSION['eno']=$_SESSION['reset'];
    }
    unset($_SESSION['reset']);
    header('Location:../Pages/userProfile.php');
  }
