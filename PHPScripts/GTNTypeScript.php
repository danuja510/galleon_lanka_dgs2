<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['gtntype']=$_POST['txtGTNType'];
        header('Location:../Pages/stocksForGTN.php');
      }