<?php
  session_start();
  if(isset($_POST['btnSubmit']))
  {
    $sid=$_SESSION['sid'];
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
    $pv_no=$_POST['txtPVno'];
    $grn_no=$_POST['txtGRN'];
    $date=$_POST['txtDate'];
    $amount=$_POST['txtAmount'];
    $remarks=$_POST['txtRemarks'];
    $sql1="INSERT INTO `payment_voucher`(`pv_no`,`grn_no`,`sid`,`date`,`amount`,`prepared_by_(eno)`,`approvedBy`,`remarks`) VALUES('".$pv_no."','".$grn_no."','".$sid."','".$date."','".$amount."','".$_SESSION['eno']."',NULL,'".$remarks."');";
    mysqli_query($con,$sql1);
    mysqli_close($con);
    header('Location:../Pages/viewPaymentVoucher.php');
  }
