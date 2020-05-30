<?php
  session_start();

  $sid=$_SESSION['supplier'];
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
   {
       die("Error while connecting to database");
   }
  $sql="SELECT * FROM `supplier` WHERE `sid`=".$sid.";";
  $rowSQL= mysqli_query( $con,$sql);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL ))
  {
   if(isset($_POST["btnsubmit"]))
   {

   $name=$_POST["txtName"];
   $address=$_POST["txtAddress"];
   $tpno=$_POST["txtTPNo"];

   $con=mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con)
   {
     die("Cannot connect to DB server");
   }
   $sql="UPDATE `supplier` SET `Name` = '".$name."', `Address` = '".$address."',`tpno`='".$tpno."'  WHERE `supplier`.`sid`=".$sid.";";
   mysqli_query($con,$sql);
   mysqli_close($con);
   $message = "Supplier Updated!";
   echo "<script type='text/javascript'>alert('$message');</script>";
   header('Location:../Pages/updateSupplierPage.php');
   }

   if(isset($_POST['btnDelete']))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Eror while connecting to database");
      }

      $sql2="UPDATE `supplier` SET `state` = 'inactive' WHERE `supplier`.`sid`=".$row['sid'].";";
      mysqli_query($con,$sql2);
      mysqli_close($con);
      header('Location:../Pages/empHome.php');
    }

  }
