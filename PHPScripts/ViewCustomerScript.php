<?php
session_start();
$con = mysqli_connect("localhost","root","","galleon_lanka");
if(!$con)
{
  die("Error while connecting to database");
}
$sql2="SELECT * FROM `customer` ;";
$rowSQL= mysqli_query( $con,$sql2);
mysqli_close($con);
while($row=mysqli_fetch_assoc( $rowSQL ))
{
  if(isset($_POST['btnUpdate'.$row['cno']])){
    $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `customer` ;";
    $_SESSION['customer']=$row['cno'];
    header('Location:../Pages/updateCustomerPage.php');
  }


if(isset($_POST['btndelete'.$row['cno']]))
{
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql2="UPDATE `customer` SET `state` = 'inactive' WHERE `customer`.`cno`=".$row['cno'].";";
  mysqli_query($con,$sql2);
  mysqli_close($con);
  header('Location:../Pages/ViewCustomer.php');
}
}
