<?php 
session_start();
    $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                  {
                   die("cannot connect to DB server");
                  }
                 $sql="SELECT * FROM `employees` ;";
                 $rowSQL= mysqli_query( $con,$sql);
              while($row = mysqli_fetch_array( $rowSQL )){
                if (isset($_POST[$row['eno']])) {
                  $_SESSION['eno2']=$row['eno'];
                  header('Location:../Pages/manageEmployees.php');
                }
              }
?>