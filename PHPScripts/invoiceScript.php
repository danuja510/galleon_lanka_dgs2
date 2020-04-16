<?php
  if(isset($_POST["btnSubmit"]))
  {
    $cno=$_POST["lstCustomer"];
    $item_no=$_POST["txtItemNo"];
    $qty=$_POST["txtQuantity"];
    $value=$_POST["txtUnitPrice"];
    $prepared_by=$_POST['eno'];
    $vehicle_no=$_POST["txtVehicleNo"];
    $con=mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Cannot connect to DB server");
    }
    $sql="INSERT INTO `invoice` (`cno`, `item_no`, `qty`, `value`, `prepared_by`,`vehicle_no`) VALUES ($cno, '".$item_no."', '".$qty."', '".$value."', '".$prepared_by."','".$vehicle_no."');";
    mysqli_query($con,$sql);
    mysqli_close($con);
    header('Location:../Pages/empHome.php');

  }
