<?php
    session_start();
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
      {
      die("Error while connecting to database");
      }

    if (isset($_POST['btnConfirm'])) {
      $ino=$_SESSION['Inum'];

      $sql="SELECT *,sum(total) as tot FROM `invoice` WHERE `invoice_no` = ".$ino." GROUP BY `invoice_no`,`cno`";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      $cid=$row['cno'];
      $tot=$_POST[$ino];
      $sql="SELECT MAX(cr_no) AS max FROM `cash_receipts`;";
      $rowSQL = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($rowSQL);
      $cr_no=$row['max']+1;
      //insert data
      if ($_SESSION['DES']=='Manager') {
        // updating records to approved
        $sql1="INSERT INTO `cash_receipts`(`cr_no`, `invoice_no`, `cno`, `remarks`, `amout`, `prepared_by`, `approved_by`, `date`) VALUES
        ($cr_no,'".$ino."','".$cid."', NULL , '".$tot."' , '".$_SESSION['eno']."' ,'".$_SESSION['eno']."' ,CURDATE());";

        // adding debtor records
        $sql2="INSERT INTO `debtors` (`no`,`cno`, `amount`, `date`) VALUES (NULL,'".$cid."', '".-$tot."',CURDATE());";
        mysqli_query( $con,$sql2);
      }else{
        $sql1="INSERT INTO `cash_receipts`(`cr_no`, `invoice_no`, `cno`, `remarks`, `amout`, `prepared_by`, `approved_by`, `date`) VALUES (NULL,'".$ino."','".$cid."', NULL , '".$tot."' , '".$_SESSION['eno']."' ,NULL ,CURDATE());";
      }
      $rowSQL= mysqli_query( $con,$sql1);
      $row = mysqli_fetch_assoc( $rowSQL );
      $_SESSION['CR']=$cr_no;
        mysqli_close($con);
      header('Location:../Pages/manageCashreceipt.php');
    }
