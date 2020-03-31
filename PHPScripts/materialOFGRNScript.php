<?php
    session_start();
    $sid=$_SESSION['sid'];
    if (isset($_POST['btnNext'])) {
        $sql1="SELECT * FROM `materials` WHERE `sid` ='".$sid."';";
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $rowSQL3= mysqli_query( $con,$sql1);
        $m="";
        $count=0;
        $count2=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['mid']])){
            $count++;
            $m=$m.$row3['mid'].'x'.$_POST['txt'.$row3['mid']].',';
            if($_POST['txt'.$row3['mid']]>0){
                $count2++;
            }
          }
        }
        if($count==0){
            header('Location:../Pages/materialOFGRN.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/materialOFGRN.php?count2=0');
        }else {
          $_SESSION['GRN']=$m;
          header('Location:../Pages/confirmGRN.php');
        }
    }