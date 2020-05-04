<?php
if(isset($_POST["btnConfirm"])){
  $name=$_POST["txtName"];
        $address=$_POST["txtAddress"];
        $type=$_POST["txtType"];
        $tpNo=$_POST["txtTPNo"];
        $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con){
    die("Cannot connect to DB server");
  }
  $sql="INSERT INTO `customer` (`cno`, `Name`, `Address`, `tpno`, `type`, `state`) VALUES (NULL, '".$name."', '".$address."', '".$tpNo."', '".$type."', 'active');";
  mysqli_query($con,$sql);
  mysqli_close($con);
        header('Location:../Pages/viewCustomer.php');
    }
