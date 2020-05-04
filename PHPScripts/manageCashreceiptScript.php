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
    header('Location:../Reports/');
  }
