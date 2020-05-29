<?php
  session_start();
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $CR=$_SESSION['CR'];

  if (isset($_POST['btnConfirm'])) {
    // updating records to approved
    $sql="UPDATE `cash_receipts` SET `approved_by` = '".$_SESSION['eno']."' WHERE `cash_receipts`.`cr_no` = ".$CR.";";
    mysqli_query( $con,$sql);

    $sql1="SELECT * FROM `cash_receipts`";
    $rowSQL=mysqli_query( $con,$sql1);
    $row=mysqli_fetch_assoc($rowSQL);

    // adding debtor records
    $sql2="INSERT INTO `debtors` (`no`,`cno`, `amount`, `date`) VALUES (NULL,'".$row['cno']."', '".-$row['amout']."',CURDATE());";
    mysqli_query( $con,$sql2);
    }
    mysqli_close($con);
    header('Location:../Pages/manageCashreceipt.php');

  if (isset($_POST['btnPrint'])) {
    header('Location:../Reports/cashReceipt.php');
  }

  if (isset($_POST['btnDelete'])) {
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql3="DELETE FROM `cash_receipts` WHERE `cr_no` =$CR;";
    mysqli_query( $con,$sql3);
    header('Location:../Pages/viewCashreceipt.php');
  }

  if (isset($_POST['btnDelete2'])) {
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql6="SELECT * FROM `cash_receipts`";
    $rowSQL=mysqli_query( $con,$sql6);
    $row=mysqli_fetch_assoc($rowSQL);
    //reverse debtor records
    $sql4="INSERT INTO `debtors` (`no`,`cno`, `amount`, `date`) VALUES (NULL,'".$row['cno']."', '".$row['amout']."',CURDATE());";
    mysqli_query( $con,$sql4);

    $sql5="DELETE FROM `cash_receipts` WHERE `cr_no` =".$_SESSION['CR'].";";
    mysqli_query( $con,$sql5);
    header('Location:../Pages/viewCashreceipt.php');
  }
