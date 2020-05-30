<?php
session_start();

    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="SELECT * FROM `payment_voucher`;";
    $rowSQL= mysqli_query( $con,$sql);
    mysqli_close($con);
    while($row=mysqli_fetch_assoc( $rowSQL ))
    {
    if (isset($_POST['btnView'.$row['pv_no']])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `payment_voucher`;";
      $_SESSION['PV']=$row['pv_no'];
      header('Location:../Pages/managePaymentVoucher.php');
    }
  }
