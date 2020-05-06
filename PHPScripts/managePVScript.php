<?php
session_start();
  $pv_no=$_SESSION['PV'];

  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql="SELECT * FROM `payment_voucher` WHERE `pv_no`=".$pv_no.";";
  $rowSQL= mysqli_query( $con,$sql);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL ))
  {
    if(isset($_POST["btsConfirm"]))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
            {
              die("Error while connecting to database");
            }
            $sql="UPDATE `payment_voucher` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `payment_voucher`.`pv_no` = ".$pv_no.";";
            mysqli_query($con,$sql);
            mysqli_close($con);
            header('Location:../Pages/managePaymentVoucher.php');
    }

    if (isset($_POST['btnPrint']))
    {
      header('Location:../Reports/paymentVoucherReport.php');
    }
  }
