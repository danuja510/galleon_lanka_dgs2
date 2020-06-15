<?php
     session_start();
     require 'stock.php';
    if (isset($_POST['btnNext'])) {
          $_SESSION['cno']=$_POST['txtCNO'];
          $stockArr= viewStocksEmployee($dept='fGoods');
          $m="";
          $count=0;
          $count2=0;
          foreach ($stockArr as $stock){
            if(isset($_POST[$stock->item_name])){
              $count++;
              $m=$m.$stock->item_name.'x'.$_POST['txt'.$stock->item_name].',';
                if($_POST['txt'.$stock->item_name]>0){
                $count2++;
            }
            }
          }
        if($count==0){
            header('Location:../Pages/createInvoice.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/createInvoice.php?count2=0');
        }else {
          $_SESSION['INVOICE']=$m;
          header('Location:../Pages/confirmInvoice.php');
        }
        }
