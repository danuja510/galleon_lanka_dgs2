<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
      // updating grn records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `grn` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `grn`.`grn_no` = ".$_SESSION['grn'].";";
      mysqli_query( $con,$sql);
      // adding/updating creditor records
      $sql2="INSERT INTO `creditors` (`sid`, `amount`, `date`) VALUES ('".$_SESSION['gsid']."', '".$_SESSION['value']."',CURDATE() );";
      mysqli_query( $con,$sql2);
      // adding/updating stock rocords
      $sql3="SELECT `mid`,`qty` FROM `grn` WHERE `grn_no`=".$_SESSION['grn']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['mid']."', '".$row3['qty']."', 'material', CURDATE(), 'store');";
          mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
      header('Location:../Pages/viewGRN2.php');
    }

    if (isset($_POST['btnPrint'])) {
      header('Location:../Reports/GRNReport.php');
    }

    if (isset($_POST['btnDelete'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="DELETE FROM `grn` WHERE  `grn_no` =".$_SESSION['grn'].";";
      mysqli_query( $con,$sql);
      mysqli_close($con);
      unset($_SESSION['grn']);
      unset($_SESSION['gsid']);
      unset($_SESSION['value']);
      header('Location:../Pages/viewGRN.php');
    }

    if (isset($_POST['btnDelete2'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      // reversing creditor records
      $sql2="INSERT INTO `creditors` (`sid`, `amount`, `date`) VALUES ('".$_SESSION['gsid']."', '".-$_SESSION['value']."',CURDATE() );";
      mysqli_query( $con,$sql2);
      // reversing stock rocords
      $sql3="SELECT `mid`,`qty` FROM `grn` WHERE `grn_no`=".$_SESSION['grn']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['mid']."', '".-$row3['qty']."', 'material', CURDATE(), 'store');";
          mysqli_query( $con,$sql2);
      }
      $sql4="DELETE FROM `grn` WHERE  `grn_no` =".$_SESSION['grn'].";";
      mysqli_query( $con,$sql4);
      mysqli_close($con);
      unset($_SESSION['grn']);
      unset($_SESSION['gsid']);
      unset($_SESSION['value']);
      header('Location:../Pages/viewGRN.php');
    }
