<?php
session_start();
if(isset($_POST["btnsubmit"]))
   {
   $amount=$_POST["txtamount"];
   $date=$_POST["txtdate"];

   $con=mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con)
   {
     die("Cannot connect to DB server");
   }
   $sql="UPDATE `creditors` SET  `amount` = '".$amount."',`date`='".$date."'  WHERE `creditors`.`crid`=".$crid.";";
   mysqli_query($con,$sql);
   mysqli_close($con);
   }
