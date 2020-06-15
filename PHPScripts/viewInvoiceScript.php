<?php
    session_start();
    require 'stock.php';
    if (isset($_POST['btnConfirm'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $nes="";
      $sql3="SELECT `item_name`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        $stockArr= viewStocksEmployee($dept='fGoods');
        foreach ($stockArr as $stock){
          if ($row3['item_name']==$stock->item_name) {
            if ($row3['qty'] > $stock->qty) {
              $nes=$nes.$row3['item_name']."-".$stock->type.",";
            }
          }
        }
      }
      mysqli_close($con);

      if ($nes!="") {
        header('Location:../Pages/viewInvoice.php?nes='.$nes);
      }else {
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
        $sql3="SELECT `item_name`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
        $rowSQL3= mysqli_query( $con,$sql3);
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          $sql2="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_name']."', '".-$row3['qty']."', 'finished_product', NOW(), 'fGoods');";
          mysqli_query( $con,$sql2);
        }
        mysqli_close($con);
        header('Location:../Pages/viewInvoice.php');
      }
    }

    if (isset($_POST['btnPrint'])) {
      header('Location:../Reports/invoiceReport.php');
    }

    if (isset($_POST['btnDelete'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="DELETE FROM `invoice` WHERE  `invoice_no` =".$_SESSION['invoice'].";";
      mysqli_query( $con,$sql);
      mysqli_close($con);
      unset($_SESSION['invoice']);
      unset($_SESSION['Ivalue']);
      unset($_SESSION['Icno']);
      header('Location:../Pages/manageInvoices.php');
    }

    if (isset($_POST['btnDelete2'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      // reversing debtor records
      $sql2="INSERT INTO `debtors` (`no`, `cno`, `amount`, `date`) VALUES (NULL, '".$_SESSION['Icno']."', '".-$_SESSION['Ivalue']."',CURDATE() );";
      mysqli_query( $con,$sql2);
      // reversing stock rocords
      $sql3="SELECT `item_name`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        $sql2="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_name']."', '".$row3['qty']."', 'finished_product', CURDATE(), 'fGoods');";
        mysqli_query( $con,$sql2);
      }
      $sql="DELETE FROM `invoice` WHERE  `invoice_no` =".$_SESSION['invoice'].";";
      mysqli_query( $con,$sql);
      mysqli_close($con);
      unset($_SESSION['invoice']);
      unset($_SESSION['Ivalue']);
      unset($_SESSION['Icno']);
      header('Location:../Pages/manageInvoices.php');
    }
/*dan*/
