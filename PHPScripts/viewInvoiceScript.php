<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
      // updating invoice records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `invoice` SET `approved_by` = '".$_SESSION['eno']."' WHERE `invoice`.`invoice_no` = ".$_SESSION['invoice'].";";
      mysqli_query( $con,$sql);
      // adding debtor records

        $sql2="INSERT INTO `debtors` (`no`,`cno`, `amount`, `date`) VALUES (NULL,'".$_SESSION['Icno']."', '".$_SESSION['Ivalue']."',CURDATE() );";
        mysqli_query( $con,$sql2);

      // updating stock rocords
      $sql3="SELECT `item_no`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".-$row3['qty']."', 'finished product', CURDATE(), 'fGoods');";
        mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
        unset($_SESSION['invoice']);
      unset($_SESSION['Ivalue']);
      unset($_SESSION['Icno']);
    header('Location:../Pages/manageInvoices.php');
    }
    if (isset($_POST['btnPrint'])) {
      header('Location:../Reports/invoiceReport.php');
    }