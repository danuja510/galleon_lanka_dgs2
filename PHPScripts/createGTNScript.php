<?php 
    session_start();
    if (isset($_POST['btnNext'])) {
        $_SESSION['dept']=$_POST['txtDept'];
        if ($_POST['txtDept']=='pfloor') {
          header('Location:../Pages/GTNType.php');
        }else{
          if ($_POST['txtDept']=='store') {
            $_SESSION['gtntype']='out';
          }
          if ($_POST['txtDept']=='fGoods') {
            $_SESSION['gtntype']='in';
          }
          header('Location:../Pages/stocksForGTN.php');
        }
    }