<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }

        for ($i=0; $i < $_SESSION['POQC']; $i++) {
          mysqli_query($con,$_SESSION['POQ'][$i]);
        }
        unset($_SESSION['POQ']);
        unset($_SESSION['POQC']);
        if ($_SESSION['DES']=='Manager') {
          $sql="UPDATE `purchase_orders` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `purchase_orders`.`po_no` = ".$_SESSION['pOrder'].";";
          mysqli_query( $con,$sql);
        }
        mysqli_close($con);
        header('Location:../Pages/managePurchaseOrder.php');
    }
