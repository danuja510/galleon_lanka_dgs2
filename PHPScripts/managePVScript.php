<?php
session_start();
  if (isset($_POST['btnConfirm'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
        // updating invoice records to approved
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="UPDATE `payment_voucher` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `payment_voucher`.`pv_no` = ".$_SESSION['PV'].";";
        mysqli_query( $con,$sql);
        // adding creditor records

          $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$_SESSION['PVSID']."', '".-$_SESSION['PVAmount']."',CURDATE() );";
          mysqli_query( $con,$sql2);
        mysqli_close($con);
        header('Location:../Pages/managePaymentVoucher.php');
    }

if (isset($_POST['btnPrint']))
    {
      header('Location:../Reports/paymentVoucherReport.php');
    }

if (isset($_POST['btnDelete'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="DELETE FROM `payment_voucher` WHERE  `pv_no` =".$_SESSION['PV'].";";
      mysqli_query( $con,$sql);
      mysqli_close($con);
      unset($_SESSION['PV']);
      unset($_SESSION['PVSID']);
      unset($_SESSION['PVAmount']);
      header('Location:../Pages/viewPaymentVoucher.php');
    }

if (isset($_POST['btnDelete2'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      // reversing creditor records
      $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$_SESSION['PVSID']."', '".$_SESSION['PVAmount']."',CURDATE() );";
      mysqli_query( $con,$sql2);
      $sql="DELETE FROM `payment_voucher` WHERE  `pv_no` =".$_SESSION['PV'].";";
      mysqli_query( $con,$sql);
      mysqli_close($con);
      unset($_SESSION['PV']);
      unset($_SESSION['PVSID']);
      unset($_SESSION['PVAmount']);
      header('Location:../Pages/viewPaymentVoucher.php');
    }