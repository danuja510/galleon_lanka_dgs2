<?php
  session_start();
  $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
  $PO=$_SESSION['pOrder'];

  if (isset($_POST['btnConfirm'])) {
    $sql="UPDATE `purchase_orders` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `purchase_orders`.`po_no` = ".$PO.";";
    mysqli_query( $con,$sql);
    }
    header('Location:../Pages/managePurchaseOrder.php');
  
  if (isset($_POST['btnDelete'])) {
    $sql1="DELETE FROM `purchase_orders` WHERE `po_no`=$PO";
    mysqli_query( $con,$sql1);
    header('Location:../Pages/viewPurchaseOrders.php');
  }

  if (isset($_POST['btnPrint'])) {
    header('Location:../Reports/printPurchaseOrder.php');
  }


  mysqli_close($con);