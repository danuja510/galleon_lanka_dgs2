<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['Inum']=$_POST['txtIno'];
        header('Location:../Pages/createCashReceipt2.php');
    }
