<?php
    session_start();
    if (isset($_POST['btnNext'])) {
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT DISTINCT `sid` FROM `purchase_orders` WHERE `po_no` = ".$_POST['txtPO'].";";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          $_SESSION['pono']=$_POST['txtPO'];
          $_SESSION['sid']=$row['sid'];
          header('Location:../Pages/materialOFGRN.php');
    }