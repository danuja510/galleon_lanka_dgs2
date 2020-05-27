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
          $sql="update invoice set remarks='".$_POST['txtRemarks']."' where invoice_no='".$_SESSION['InvoiceNo']."'";
          mysqli_query($con,$sql);
        }
        mysqli_close($con);
        unset($_SESSION['InvoiceQC']);
        unset($_SESSION['InvoiceQ']);
        unset($_SESSION['InvoiceNo']);
        header('Location:../Pages/manageInvoices.php');
    }
