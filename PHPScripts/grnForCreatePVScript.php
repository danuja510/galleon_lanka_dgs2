<?php
    session_start();
    if (isset($_POST['btnNext'])) {
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `grn` WHERE `sid` ='".$_SESSION['sid']."' and approvedBy is not null group by grn_no;";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          $_SESSION['grn']=$_POST['txtGRN'];
          header('Location:../Pages/CreatePaymentVoucher2.php');
    }
