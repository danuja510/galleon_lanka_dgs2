<?php
if(isset($_POST['btnSubmit']))
   {
     $Name = $_POST['txtName'];
     $Type = $_POST['lstType'];
     $sid = $_POST['lstSid'];
     $Value= $_POST['txtValue'];

$con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("cannot connect to DB server");
    }
     $sql1="INSERT INTO `materials` (`Name`, `Type`, `sid`, `value`, `status`) VALUES ('".$Name."','".$Type."','".$sid."','".$Value."', 'active');";
    mysqli_query($con,$sql1);
    header('Location:../Pages/addMaterials.php');
   }
