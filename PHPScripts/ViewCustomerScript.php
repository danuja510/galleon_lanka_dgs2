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

}
