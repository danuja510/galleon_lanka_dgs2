<?php
  session_start();
  $PO=$_SESSION['pOrder'];
  if (isset($_POST['btnConfirm'])) {
    // updating invoice records to approved
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="UPDATE `purchase_orders` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `purchase_orders`.`po_no` = ".$PO.";";
    mysqli_query( $con,$sql);
    // adding creditor records

      $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$sid."', '".$value."',CURDATE());";
      mysqli_query( $con,$sql2);
    }
    mysqli_close($con);
    header('Location:../Pages/managePurchaseOrder.php');

  if (isset($_POST['btnPrint'])) {
    header('Location:../Reports/printPurchaseOrder.php');
  }