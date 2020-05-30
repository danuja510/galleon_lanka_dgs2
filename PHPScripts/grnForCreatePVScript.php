<?php
  session_start();

    $sid=$_SESSION['sid'];
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql1="SELECT * FROM `grn` WHERE `sid` ='".$sid."';";
    $rowSQL1= mysqli_query( $con,$sql1);
    mysqli_close($con);
    while($row1=mysqli_fetch_assoc( $rowSQL1 ))
    {
      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `grn`;";
        $grnR=$row1['grn_no'];
        $_SESSION['grn']=$_POST[$grnR];
        header('Location:../Pages/CreatePaymentVoucher2.php');
      }
    }
