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
    if ($_SESSION['DES']=='Manager') {
      $sql1="INSERT INTO `payment_voucher`(`pv_no`,`grn_no`,`sid`,`date`,`amount`,`prepared_by_(eno)`,`approvedBy`,`remarks`) VALUES('".$pv_no."','".$grn_no."','".$sid."','".$date."','".$amount."','".$_SESSION['eno']."','".$_SESSION['eno']."','".$remarks."');";
      $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$sid."', '".-$amount."',CURDATE() );";
      mysqli_query( $con,$sql2);
    }else{
      $sql1="INSERT INTO `payment_voucher`(`pv_no`,`grn_no`,`sid`,`date`,`amount`,`prepared_by_(eno)`,`approvedBy`,`remarks`) VALUES('".$pv_no."','".$grn_no."','".$sid."','".$date."','".$amount."','".$_SESSION['eno']."',NULL,'".$remarks."');";
    }
    mysqli_query($con,$sql1);
    mysqli_close($con);
    $_SESSION['PV']=$pv_no;
    header('Location:../Pages/managePaymentVoucher.php');
  }
