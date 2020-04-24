<?php
    session_start();

                if($_SESSION['gtntype']=='out'){
                  if ($_SESSION['dept']=='store') {
                    $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' AND `type`='material' GROUP BY `item_no`,`type`;";
                    $iType='material';
                  }elseif ($_SESSION['dept']=='pfloor') {
                    $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."'AND `type`='finished_product' GROUP BY `item_no`,`type`;";
                    $iType='finished_product';
                  }
                }else {
                  if ($_SESSION['dept']=='pfloor') {
                    $sql="SELECT * FROM `materials`;";
                    $iType='material';
                  }
                  if ($_SESSION['dept']=='fGoods') {
                    $sql="SELECT * FROM `finished_products`;";
                    $iType='finished_product';
                  }
                }


      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        if ($_SESSION['gtntype']=='out') {
          $rowSQL3= mysqli_query( $con,$sql);
          $m=$_SESSION['gtntype']."+";
          $count=0;
            $count2=0;
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            if(isset($_POST[$row3['item_no']])){
              $count++;
              $m=$m.$row3['item_no'].'x'.$_POST['txt'.$row3['item_no']].'x'.$iType.',';
                if($_POST['txt'.$row3['item_no']]>0){
                $count2++;
            }
            }
          }
        }else {
          if ($_SESSION['dept']=='pfloor') {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$_SESSION['gtntype']."+";
            $count=0;
              $count2=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['mid']])){
                $count++;
                $m=$m.$row3['mid'].'x'.$_POST['txt'.$row3['mid']].'x'.$iType.',';
                  if($_POST['txt'.$row3['mid']]>0){
                $count2++;
            }
              }
            }
          }
          if ($_SESSION['dept']=='fGoods') {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$_SESSION['gtntype']."+";
            $count=0;
              $count2=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['fp_id']])){
                $count++;
                $m=$m.$row3['fp_id'].'x'.$_POST['txt'.$row3['fp_id']].'x'.$iType.',';
                  if($_POST['txt'.$row3['fp_id']]>0){
                $count2++;
            }
              }
            }
          }
        }
          if($count==0){
            header('Location:../Pages/stocksForGTN.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/stocksForGTN.php?count2=0');
        }else {
          $_SESSION['GTN']=$m;
          header('Location:../Pages/confirmGTN.php');
        }
      }
