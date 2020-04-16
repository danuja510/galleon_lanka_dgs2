<?php
   if(isset($_POST["btnsubmit"]))
   {
     $sid=$_SESSION['supplier'];
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `supplier` WHERE `sid`=".$sid.";";
   $name=$_POST["txtName"];
   $address=$_POST["txtAddress"];
   $tpno=$_POST["txtTPNo"];

   $con=mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con)
   {
     die("Cannot connect to DB server");
   }
   $sql="UPDATE `supplier` SET `Name` = '".$name."', `Address` = '".$address."',`tpno`='".$tpno."'  WHERE `supplier`.`sid`=".$sid.";";
   mysqli_query($con,$sql);
   mysqli_close($con);
   }
