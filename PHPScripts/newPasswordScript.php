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
    $previous="";
    if (isset($_GET['f'])) {
      $previous=$_GET['f'];
    }
    switch ($previous) {
      case 'memp':
        header('Location:../Pages/manageEmployees.php');
        break;

      case 'up':
        header('Location:../Pages/userProfile.php');
        break;

      default:
        header('Location:../Pages/signIn.php');
        break;
    }
  }
