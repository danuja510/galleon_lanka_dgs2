<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
         die("Error while connecting to database");
        }
        $sql="SELECT * FROM `finished_products` where status ='active';";
        $rowSQL3= mysqli_query( $con,$sql);
        mysqli_close($con);
        $m="";
        $count=0;
        $count2=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['fp_id']])){
            $count++;
            $m=$m.$row3['fp_id'].'x'.$_POST['txt'.$row3['fp_id']].',';
            if($_POST['txt'.$row3['fp_id']]>0){
                $count2++;
            }
          }
        }
        if($count==0){
            header('Location:../Pages/inputFinishedGoods.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/inputFinishedGoods.php?count2=0');
        }else {
          $_SESSION['ifg']=$m;
          header('Location:../Pages/updateStock.php');
        }
      }
