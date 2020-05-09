<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['sid']=$_POST['lstSupplier'];
        header('Location:../Pages/grnForCreatePV.php');
    }
