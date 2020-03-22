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
        mysqli_close($con);
        unset($_SESSION['GRNQ']);
        unset($_SESSION['GRNQC']);
        header('Location:../Pages/viewGRN.php');
    }