<?php
  if(isset($_POST['btnSubmit']))
  {
    $sid=$_SESSION['sid'];
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";


    $grn_no=$_POST['txtGrn'];
    $sid=$_POST['lstSupplier'];
    $date=$_POST['txtDate'];
    $amount=$_POST['txtAmount'];
    $remarks=$_POST['txtRemarks'];

    $con1= mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con1)
    {
      die("cannot connect to DB server");
    }
    $sql1="INSERT INTO `payment_voucher`(`grn_no`,`sid`,`date`,`amount`,`prepared_by_(eno)`,`remarks`) VALUES('".$grn_no."','".$sid."','".$date."','".$amount."','','".$remarks."');";
    mysqli_query($con1,$sql1);
    mysqli_close($con1);
  }
