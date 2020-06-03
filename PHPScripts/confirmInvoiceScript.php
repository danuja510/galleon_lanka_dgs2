<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i < $_SESSION['InvoiceQC']; $i++) {
          mysqli_query($con,$_SESSION['InvoiceQ'][$i]);
        }
        if ($_POST['txtRemarks']!="") {
          $sql="update invoice set remarks='".$_POST['txtRemarks']."' where invoice_no='".$_SESSION['invoice']."'";
          mysqli_query($con,$sql);
        }
        if ($_SESSION['DES']=='Manager') {
          $nes="";
          $sql3="SELECT `item_no`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
          $rowSQL3= mysqli_query( $con,$sql3);
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='fGoods'AND `type`='finished_product' AND `item_no`='".$row3['item_no']."' GROUP BY `item_no`,`type`;";
            $rowSQL= mysqli_query( $con,$sql);
            $row= mysqli_fetch_array($rowSQL);
            if ($row3['qty'] > $row['Qty']) {
              $nes=$nes.$row3['item_no']."-".$row['type'].",";
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
            $sql="SELECT *,sum(total) as price FROM `invoice` where `invoice_no`=".$_SESSION['invoice']." GROUP BY `invoice_no`;";
            $rowSQL= mysqli_query( $con,$sql);
            $row = mysqli_fetch_array( $rowSQL );
              $sql2="INSERT INTO `debtors` (`no`,`cno`, `amount`, `date`) VALUES (NULL,'".$_SESSION['Icno']."', '".$row['price']."',CURDATE() );";
              mysqli_query( $con,$sql2);

            // updating stock rocords
            $sql3="SELECT `item_no`,`qty` FROM `invoice` WHERE `invoice_no`=".$_SESSION['invoice']."";
            $rowSQL3= mysqli_query( $con,$sql3);
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".-$row3['qty']."', 'finished_product', CURDATE(), 'fGoods');";
              mysqli_query( $con,$sql2);
            }
          }
        }
        mysqli_close($con);
        unset($_SESSION['InvoiceQC']);
        unset($_SESSION['InvoiceQ']);
        header('Location:../Pages/viewInvoice.php');
    }
