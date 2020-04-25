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
    $sql1="UPDATE `employees` SET `password` = '".$cpwd."' WHERE `employees`.`eno` = '".$_SESSION['reset']."'";
    mysqli_query($con1,$sql1);
    header('Location:../Pages/newPassword.php');
  }
