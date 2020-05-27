<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i < $_SESSION['GTNQC']; $i++) {
          mysqli_query($con,$_SESSION['GTNQ'][$i]);
        }
        if ($_POST['txtRemarks']!="") {
          $sql="update gtn set remarks='".$_POST['txtRemarks']."' where gtn_no='".$_SESSION['GTNNo']."'";
          mysqli_query($con,$sql);
          echo $sql;
        }
        mysqli_close($con);
        unset($_SESSION['GTNQ']);
        unset($_SESSION['GTNQC']);
        unset($_SESSION['GTNNo']);
        header('Location:../Pages/manageGTN.php');
    }
