<?php
    session_start();
    if($_SESSION['gtntype']=='out' || $_SESSION['gtntype']=='return_out'){
      if ($_SESSION['dept']=='store') {
        $sql="SELECT `item_name`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' AND `type`='material' GROUP BY `item_name`,`type`;";
        $iType='material';
      }elseif ($_SESSION['dept']=='pFloor') {
        if ($_SESSION['gtntype']=='out') {
          $sql="SELECT `item_name`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."'AND `type`='finished_product' GROUP BY `item_name`,`type`;";
          $iType='finished_product';
        }elseif ($_SESSION['gtntype']=='return_out') {
          $sql="SELECT `item_name`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' AND `type`='material' GROUP BY `item_name`,`type`;";
          $iType='material';
        }
      }elseif ($_SESSION['dept']=='fGoods') {
        $sql="SELECT `item_name`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."'AND `type`='finished_product' GROUP BY `item_name`,`type`;";
        $iType='finished_product';
      }
    }else {
      if ($_SESSION['dept']=='pFloor') {
        if ($_SESSION['gtntype']=='in') {
          $sql="SELECT * FROM `materials` where status='active';";
          $iType='material';
        }elseif ($_SESSION['gtntype']=='return_in') {
          $sql="SELECT * FROM `finished_products` where status='active';";
          $iType='finished_product';
        }
      }elseif ($_SESSION['dept']=='fGoods') {
        $sql="SELECT * FROM `finished_products` where status='active';";
        $iType='finished_product';
      }elseif ($_SESSION['dept']=='store') {
        $sql="SELECT * FROM `materials` where status='active';";
        $iType='material';
      }
    }


      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        if ($_SESSION['gtntype']=='out' || $_SESSION['gtntype']=='return_out') {
          $rowSQL3= mysqli_query( $con,$sql);
          $m=$_SESSION['gtntype']."+";
          $count=0;
          $count2=0;

            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['item_name'].$iType])){
                $count++;
                $m=$m.$row3['item_name'].'x'.$_POST['txt'.$row3['item_name'].$iType].'x'.$iType.',';
                  if($_POST['txt'.$row3['item_name'].$iType]>0){
                  $count2++;
                }
              }
            }
        }else {
          if ($_SESSION['dept']=='fGoods' || ($_SESSION['dept']=='pFloor' && $_SESSION['gtntype']=='return_in')) {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$_SESSION['gtntype']."+";
            $count=0;
            $count2=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['Name'].$iType])){
                $count++;
                $m=$m.$row3['Name'].'x'.$_POST['txt'.$row3['Name'].$iType].'x'.$iType.',';
                if($_POST['txt'.$row3['Name'].$iType]>0){
                  $count2++;
                }
              }
            }
          }
          if ($_SESSION['dept']=='store' || ($_SESSION['dept']=='pFloor' && $_SESSION['gtntype']=='in')) {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$_SESSION['gtntype']."+";
            $count=0;
            $count2=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['Name'].$iType])){
                $count++;
                $m=$m.$row3['Name'].'x'.$_POST['txt'.$row3['Name'].$iType].'x'.$iType.',';
                if($_POST['txt'.$row3['Name'].$iType]>0){
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
/*dan*/
