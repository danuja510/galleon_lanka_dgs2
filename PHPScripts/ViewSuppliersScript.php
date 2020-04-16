<?php
  session_start();
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql2="SELECT * FROM `supplier`;";
  $rowSQL= mysqli_query( $con,$sql2);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    if(isset($_POST['btnUpdate'.$row['sid']]))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `supplier`;";
      $_SESSION['supplier']=$row['sid'];
      header('Location:../Pages/updateSupplierPage.php');
    }

    if(isset($_POST['btnDelete'.$row['sid']]))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Eror while connecting to database");
      }

      $sql2="UPDATE `supplier` SET `state` = 'inactive' WHERE `supplier`.`sid`=".$row['sid'].";";
      mysqli_query($con,$sql2);
      mysqli_close($con);
      header('Location:../Pages/ViewSuppliers.php');
    }
  }
