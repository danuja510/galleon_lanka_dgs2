<?php
  session_start();
  if(isset($_POST['btnsubmit'])){
    $eno=$_POST['txtENO'];
    $pass=$_POST['txtPass'];
    $sql="SELECT * FROM `employees` WHERE `eno` = ".$eno." AND `password` LIKE '".md5($pass)."' and status='active';";
    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $result= mysqli_query($con,$sql);

    if(mysqli_num_rows($result)>0){
      $row=mysqli_fetch_array($result);

      if ($row[ 'Designation']=='Manager') {
        $_SESSION['DES']='Manager';
        $_SESSION['DEPT']='Manager';
      }else {
        if ($row[ 'Designation']=='Employee') {
          $_SESSION['DES']='Employee';
          $_SESSION['DEPT']=$row[ 'Dept'];
        }
      }
      $_SESSION['eno']=$eno;
      header('Location:../Pages/empHome.php');
    }else{
      header('Location:../Pages/signIn.php?s=fail');
    }
  }
