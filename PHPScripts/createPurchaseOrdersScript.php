<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['sid']=$_POST['txtSupplier'];
        header('Location:../Pages/materialsForPO.php');
    }