<?php
session_start();
$con=mysqli_connect("localhost","root","","galleon_lanka");
if(!$con){
  die("Cannot connect to DB server");
}

if(isset($_POST["btnUpdate"])){
    $name=$_POST["txtName"];
    $b=$_POST["lstBomid"];
    $val=$_POST["txtValue"];  
    $sql3="UPDATE `finished_products` SET `Name` = '".$name."',`bom_id`='".$b."', `value` = '".$val."' WHERE `fp_id` = '".$_SESSION['fpid']."'";
    mysqli_query($con,$sql3);
    header('Location:../Pages/manageFinishedProducts.php');
    }
  
if(isset($_POST["btnDelete"])){
    $sql4="UPDATE `finished_products` SET `status` = 'inactive' WHERE `fp_id` = '".$_SESSION['fpid']."'";
    mysqli_query($con,$sql4);
    header('Location:../Pages/viewFinishedProducts.php');
    }