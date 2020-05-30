<?php
session_start();

$cno=$_SESSION['customer'];
$con = mysqli_connect("localhost","root","","galleon_lanka");
if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql="SELECT * FROM `customer` WHERE `cno`=".$cno.";";
  $rowSQL= mysqli_query( $con,$sql);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL ))
  {
if(isset($_POST["btnsubmit"]))
{
$name=$_POST["txtName"];
$address=$_POST["txtAddress"];
$tpno=$_POST["txtTPNo"];
$type=$_POST["txtType"];

$con=mysqli_connect("localhost","root","","galleon_lanka");
if(!$con)
{
  die("Cannot connect to DB server");
}
$sql="UPDATE `customer` SET `Name` = '".$name."', `Address` = '".$address."',`tpno`='".$tpno."', `type`= '".$type."' WHERE `customer`.`cno`=".$cno.";";
mysqli_query($con,$sql);
mysqli_close($con);
header('Location:../Pages/updateCustomerPage.php');
}

if(isset($_POST["btnDelete"]))
{
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql2="UPDATE `customer` SET `state` = 'inactive' WHERE `customer`.`cno`=".$row['cno'].";";
  mysqli_query($con,$sql2);
  mysqli_close($con);
  header('Location:../Pages/empHome.php');
}
}
