<?php
    session_start();
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
      {
      die("Error while connecting to database");
      }

    if (isset($_POST['btnNext'])) {
      $ino=$_SESSION['Inum'];

      $sql="SELECT *,sum(total) as tot FROM `invoice` WHERE `invoice_no` = ".$ino." GROUP BY `invoice_no`,`cno`";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      $cid=$row['cno'];
      $tot=$row['tot'];

      $sql1="SELECT * FROM `customer` WHERE `cno` = '".$cid."';";
      $rowSQL1= mysqli_query( $con,$sql1);
      $row1=mysqli_fetch_assoc( $rowSQL1 );
      $cname=$row['Name'];

      //insert data
      $sql2="INSERT INTO `cash_receipts`(`no`, `cr_no`, `invoice_no`, `cno`, `remarks`, `amout`, `prepared_by`, `approved_by`, `date`)
                                  VALUES (NULL,'".$ino."','".$ino."','".$cid."', NULL , '".$tot."' , '".$_SESSION['eno']."' ,NULL ,CURDATE());";
      mysqli_query($con, $sql2);
      header('Location:../Pages/viewCashreceipt.php');
    }
