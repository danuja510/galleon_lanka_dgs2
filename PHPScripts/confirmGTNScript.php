<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i < $_SESSION['GTNQC']; $i++) {
          mysqli_query($con,$_SESSION['GTNQ'][$i]);
        }
        if ($_POST['txtRemarks']!="") {
          $sql="update gtn set remarks='".$_POST['txtRemarks']."' where gtn_no='".$_SESSION['gtn']."'";
          mysqli_query($con,$sql);
        }
        if ($_SESSION['DES']=='Manager') {

            if ($_SESSION['gtype']=='out' || $_SESSION['gtype']=='return_out') {
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $nes="";
              $sql3="SELECT `item_name`,`qty`,`item_type` FROM `gtn` WHERE `gtn_no`=".$_SESSION['gtn']."";
              $rowSQL3= mysqli_query( $con,$sql3);
              while($row3=mysqli_fetch_assoc( $rowSQL3 )){
                $sql="SELECT `item_name`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['gdept']."'AND `type`='".$row3['item_type']."' AND `item_name`='".$row3['item_name']."' GROUP BY `item_name`,`type`;";
                $rowSQL= mysqli_query( $con,$sql);
                $row= mysqli_fetch_array($rowSQL);
                if ($row3['qty'] > $row['Qty']) {
                  $nes=$nes.$row3['item_name']."-".$row['type'].",";
                }
              }
              mysqli_close($con);
              if ($nes!="") {
                header('Location:../Pages/viewGTN.php?nes='.$nes);
              }else{
                // updating gtn records to approved
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $sql="UPDATE `gtn` SET `approved_by` = '".$_SESSION['eno']."' WHERE `gtn`.`gtn_no` = ".$_SESSION['gtn'].";";
                mysqli_query( $con,$sql);
                // adding/updating stock rocords
                $sql3="SELECT `item_name`,`qty`,`item_type` FROM `gtn` WHERE `gtn_no`=".$_SESSION['gtn']."";
                $rowSQL3= mysqli_query( $con,$sql3);
                while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              	  $sql2="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_name']."', '".-$row3['qty']."', '".$row3['item_type']."', NOW(), '".$_SESSION['gdept']."');";
                  mysqli_query( $con,$sql2);
                }
                mysqli_close($con);
                header('Location:../Pages/viewGTN.php');
              }
            }elseif ($_SESSION['gtype']=='in' || $_SESSION['gtype']=='return_in') {
              // updating gtn records to approved
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="UPDATE `gtn` SET `approved_by` = '".$_SESSION['eno']."' WHERE `gtn`.`gtn_no` = ".$_SESSION['gtn'].";";
              mysqli_query( $con,$sql);
              // adding/updating stock rocords
              $sql3="SELECT `item_name`,`qty`,`item_type` FROM `gtn` WHERE `gtn_no`=".$_SESSION['gtn']."";
              $rowSQL3= mysqli_query( $con,$sql3);
              while($row3=mysqli_fetch_assoc( $rowSQL3 )){
                $sql2="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_name']."', '".$row3['qty']."', '".$row3['item_type']."', NOW(), '".$_SESSION['gdept']."');";
                mysqli_query( $con,$sql2);
              }
            }
        }
        mysqli_close($con);
        unset($_SESSION['GTNQ']);
        unset($_SESSION['GTNQC']);
        header('Location:../Pages/viewGTN.php');
    }
