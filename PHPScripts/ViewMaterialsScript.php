<?php
session_start();
$con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
    {
     die("cannot connect to DB server");
    }

   $sql="SELECT * FROM `materials`";
   $rowSQL= mysqli_query( $con,$sql);

  while($row = mysqli_fetch_array( $rowSQL ))
  {
    if (isset($_POST[$row['mid']])) {
      $_SESSION['mid']=$row['mid'];
      header('Location:../Pages/ManageMaterials.php');
    }
  }
