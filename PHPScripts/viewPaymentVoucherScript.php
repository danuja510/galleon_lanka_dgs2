<?php
session_start();
    $payment_voucher=$_SESSION['PVoucher'];
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="SELECT * FROM `payment_voucher` GROUP BY `pv_no`;";
    $rowSQL= mysqli_query( $con,$sql);
    mysqli_close($con);

    if (isset($_POST['btnConfirm'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `payment_voucher` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `payment_voucher`.`pv_no` = ".$pv_no.";";
      mysqli_query( $con,$sql);
    }

    if (isset($_POST['btnPrint']))
    {
      header('Location:../Reports/paymentVoucherReport.php');
    }
