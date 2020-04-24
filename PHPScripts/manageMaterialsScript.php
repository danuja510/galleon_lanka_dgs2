<?php
  session_start();
  $con=mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con){
    die("Cannot connect to DB server");
  }
  
    if(isset($_POST["btnUpdate"])){

      $name=$_POST["txtName"];
      $type=$_POST["lstType"];
      $s=$_POST["lstSupplier"];
      $val=$_POST["txtValue"];

      $sql3="UPDATE `materials` SET `Name` = '".$name."',`Type`='".$type."', `sid`='".$s."', `value` = '".$val."' WHERE `mid` = '".$_SESSION['mid']."'";
      mysqli_query($con,$sql3);
      header('Location:../Pages/manageMaterials.php');
      }

  if(isset($_POST["btnDelete"])){
    $sql4="UPDATE `materials` SET `status` = 'inactive' WHERE `mid` = '".$_SESSION['mid']."'";
    mysqli_query($con,$sql4);
    header('Location:../Pages/manageMaterials.php');
    }
