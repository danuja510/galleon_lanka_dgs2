<?php
session_start();

$con=mysqli_connect("localhost","root","","galleon_lanka");
if(!$con){
  die("Cannot connect to DB server");
}

if(isset($_POST["btnUpdate"])){
    $name=$_POST["txtName"];
    $dep=$_POST["lstDepartment"];
    $email=$_POST["txtEmail"];

    $sql1="UPDATE `employees` SET `Name` = '".$name."',`Dept`='".$dep."',`email` = '".$email."' WHERE `eno` = '".$_SESSION['eno2']."'";
    mysqli_query($con,$sql1);
    header('Location:../Pages/manageEmployees.php');
    }

if(isset($_POST["btnDelete"])){
    $sql3="UPDATE `employees` SET `status` = 'inactive' WHERE `eno` = '".$_SESSION['eno2']."'";
    mysqli_query($con,$sql3);
    header('Location:../Pages/manageEmployees.php');
    }

if(isset($_POST["btnConfirm"])){
    $sql4="UPDATE `employees` SET `Designation` = 'Manager' WHERE `eno` = '".$_SESSION['eno2']."'";
    $sql5="UPDATE `employees` SET `Dept` = 'Manager' WHERE `eno` = '".$_SESSION['eno2']."'";
    mysqli_query($con,$sql4);
    mysqli_query($con,$sql5);
    header('Location:../Pages/manageEmployees.php');
    }

if(isset($_POST["btnDemote"])){
    $sql4="UPDATE `employees` SET `Designation` = 'Employee' WHERE `eno` = '".$_SESSION['eno2']."'";
    $sql5="UPDATE `employees` SET `Dept` = 'pFloor' WHERE `eno` = '".$_SESSION['eno2']."'";
    mysqli_query($con,$sql4);
    mysqli_query($con,$sql5);
    header('Location:../Pages/manageEmployees.php');
    }

if(isset($_POST["btnNext"])){
    $_SESSION['reset'] = $_SESSION['eno2'];
    header('Location:../Pages/newPassword.php?f=memp');
    }

  mysqli_close($con);
