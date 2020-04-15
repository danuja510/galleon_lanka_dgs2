<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
      // updating gtn records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `gtn` SET `approved_by` = '".$_SESSION['eno']."' WHERE `gtn`.`gtn_no` = ".$_SESSION['gtn'].";";
      mysqli_query( $con,$sql);
        // adding/updating stock rocords
      $sql3="SELECT `item_no`,`qty`,`item_type` FROM `gtn` WHERE `gtn_no`=".$_SESSION['gtn']."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
    	  if($_SESSION['gtype']=='in'){
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".$row3['qty']."', '".$row3['item_type']."', CURDATE(), '".$_SESSION['gdept']."');";
        }elseif ($_SESSION['gtype']=='out') {
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".-$row3['qty']."', '".$row3['item_type']."', CURDATE(), '".$_SESSION['gdept']."');";
        }
        mysqli_query( $con,$sql2);

      }
      mysqli_close($con);
        unset($_SESSION['gtn']);
      unset($_SESSION['gdept']);
      unset($_SESSION['gtype']);
    header('Location:../Pages/manageGTN.php');
    }
    if (isset($_POST['btnPrint'])) {
      header('Location:../Reports/GTNReport.php');
    }
