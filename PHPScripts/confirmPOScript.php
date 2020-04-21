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
        mysqli_close($con);
        unset($_SESSION['POQ']);
        unset($_SESSION['POQC']);
        header('Location:../Pages/viewPurchaseOrders.php');
    }
