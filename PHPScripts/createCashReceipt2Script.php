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
      //insert data
      $sql2="INSERT INTO `cash_receipts`(`cr_no`, `invoice_no`, `cno`, `remarks`, `amout`, `prepared_by`, `approved_by`, `date`)
                                  VALUES (NULL,'".$ino."','".$cid."', NULL , '".$tot."' , '".$_SESSION['eno']."' ,NULL ,CURDATE());";
      mysqli_query($con, $sql2);
        mysqli_close($con);
      header('Location:../Pages/viewCashreceipt.php');
    }
