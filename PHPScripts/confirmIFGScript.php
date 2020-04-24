<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        //updating/inserting finished goods to stocks
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i <sizeof($_SESSION['USQ_1']) ; $i++) {
          mysqli_query( $con,$_SESSION['USQ_1'][$i]);
        }
        for ($i=0; $i <sizeof($_SESSION['USQ_2']) ; $i++) {
          mysqli_query( $con,$_SESSION['USQ_2'][$i]);
        }
        mysqli_close($con);
        unset($_SESSION['USQ_1']);
        unset($_SESSION['USQ_2']);
        header('Location:../Pages/viewStocks.php');
      }
