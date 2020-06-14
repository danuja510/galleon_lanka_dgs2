<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i < $_SESSION['GRNQC']; $i++) {
          mysqli_query($con,$_SESSION['GRNQ'][$i]);
        }
        if ($_POST['txtRemarks']!="") {
          $sql="update grn set remarks='".$_POST['txtRemarks']."' where grn_no='".$_SESSION['grn']."'";
          mysqli_query($con,$sql);
        }
        if ($_SESSION['DES']=='Manager') {
          $sql="UPDATE `grn` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `grn`.`grn_no` = ".$_SESSION['grn'].";";
          mysqli_query( $con,$sql);
          // adding/updating creditor records
          $sql="SELECT *,sum(amount) as value FROM `grn` where `grn_no`=".$_SESSION['grn']." GROUP BY `grn_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          $sql2="INSERT INTO `creditors` (`sid`, `amount`, `date`) VALUES ('".$_SESSION['gsid']."', '".$row['value']."',CURDATE() );";
          mysqli_query( $con,$sql2);
          // adding/updating stock rocords
          $sql3="SELECT `mid`,`qty` FROM `grn` WHERE `grn_no`=".$_SESSION['grn']."";
          $rowSQL3= mysqli_query( $con,$sql3);
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            $sql4="SELECT `Name` FROM `materials` WHERE `mid`=".$row3['mid']."";
            $rowSQL4= mysqli_query( $con,$sql4);
            $row4=mysqli_fetch_array( $rowSQL4 );
              $sql2="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row4['Name']."', '".$row3['qty']."', 'material', NOW(), 'store');";
              mysqli_query( $con,$sql2);
          }
        }
        mysqli_close($con);
        unset($_SESSION['GRNQ']);
        unset($_SESSION['GRNQC']);
        header('Location:../Pages/viewGRN2.php');
    }
