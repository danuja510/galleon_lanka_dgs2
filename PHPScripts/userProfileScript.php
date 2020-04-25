<?php
session_start();

$con=mysqli_connect("localhost","root","","galleon_lanka");
if(!$con){
  die("Cannot connect to DB server");
}

if(isset($_POST["btnUpdate"])){
    $name=$_POST["txtName"];
    $pass=$_POST["txtPwd"];
    $email=$_POST["txtEmail"];

    $sql1="UPDATE `employees` SET `Name` = '".$name."', `password` = '".$pass."',`email` = '".$email."' WHERE `eno` = '".$_SESSION['eno']."'";
    mysqli_query($con,$sql1);
    header('Location:../Pages/userProfile.php');
    }
