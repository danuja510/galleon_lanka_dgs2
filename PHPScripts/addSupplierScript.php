<?php
session_start();
  if(isset($_POST['btnSubmit']))
  {
       $name = $_POST['txtName'];
       $Address = $_POST['txtAddress'];
       $Tno = $_POST['txtTno'];

       $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
       {
         die("cannot connect to DB server");
       }
       $sql="INSERT INTO `Supplier`(`Name`, `Address`, `tpno`, `state`) VALUES ('".$name."','".$Address."','".$Tno."', 'active')";
              mysqli_query($con,$sql);
              header('Location:../Pages/addSupplier.php');
  }
