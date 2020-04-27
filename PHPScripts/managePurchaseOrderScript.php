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
    
    $sql1="SELECT * FROM `purchase_orders` where `po_no`=".$PO.";";
    $rowSQL= mysqli_query( $con,$sql1);
    $row = mysqli_fetch_array( $rowSQL );

    // adding creditor records
      $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$row['sid']."', '".$row['amount']."',CURDATE());";
      mysqli_query( $con,$sql2);
    }
    mysqli_close($con);
    header('Location:../Pages/managePurchaseOrder.php');

  if (isset($_POST['btnPrint'])) {
    header('Location:../Reports/printPurchaseOrder.php');
  }