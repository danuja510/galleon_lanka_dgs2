<?php
session_start();
if(isset($_POST['btnSubmit']))
{
  $eno=$_POST['txtEno'];
  $email=$_POST['txtEmail'];
  $sql="SELECT * FROM `employees` WHERE `eno` = ".$eno." AND `email` LIKE '".$email."';";
  $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $result= mysqli_query($con,$sql);

  if(mysqli_num_rows($result)>0)
    {
    $_SESSION['reset']=$eno;
    header('Location:../Pages/newPassword.php');
    }
    else
    {
      $_SESSION['invalid']=1;
      header('Location:../Pages/resetPassword.php');
    }

}
