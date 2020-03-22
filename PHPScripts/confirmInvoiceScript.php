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
        mysqli_close($con);
        unset($_SESSION['InvoiceQC']);
        unset($_SESSION['InvoiceQ']);
        header('Location:../Pages/manageInvoices.php');
    }