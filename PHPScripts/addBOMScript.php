<?php
    session_start();
        if (isset($_POST['btnReset'])) {
        unset($_SESSION["bom"]);
        header('Location:../Pages/addBOM.php');
    }

      if (isset($_POST['btnNext'])) {
        if (isset($_SESSION["bom"])) {
          $found=FALSE;
          for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
            $bom=explode(',',$_SESSION["bom"][$i]);
            if ($bom[0]==$_POST['txtName']) {
              $_SESSION["bom"][$i]="".$_POST['txtName'].",".($bom[1]+$_POST['txtQty'])."";
              $found=TRUE;
              header('Location:../Pages/addBOM.php');
            }
          }
          if (!$found==TRUE) {
            $_SESSION["bom"][sizeof($_SESSION["bom"])]=$_POST['txtName'].",".$_POST['txtQty'];
            header('Location:../Pages/addBOM.php');
          }
        }else{
          $_SESSION["bom"]=[];
          $_SESSION["bom"][0]=$_POST['txtName'].",".$_POST['txtQty'];
          header('Location:../Pages/addBOM.php');
        }
      }

      if (isset($_POST['btnSubmit'])) {
        if (isset($_SESSION["bom"])) {
          $found=FALSE;
          for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
            $bom=explode(',',$_SESSION["bom"][$i]);
            if ($bom[0]==$_POST['txtName']) {
              $_SESSION["bom"][$i]="".$bom[0].",".($bom[1]+$_POST['txtQty'])."";
              $found=TRUE;
            }
          }
          if (!$found==TRUE) {
            $_SESSION["bom"][sizeof($_SESSION["bom"])]=$_POST['txtName'].",".$_POST['txtQty'];
          }
        }else{
          $_SESSION["bom"]=[];
          $_SESSION["bom"][0]=$_POST['txtName'].",".$_POST['txtQty'];

        }
        header('Location:../Pages/confirmBOM.php');
      }