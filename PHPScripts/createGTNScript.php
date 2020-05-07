<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['dept']=$_POST['txtDept'];
        header('Location:../Pages/GTNType.php');
    }
