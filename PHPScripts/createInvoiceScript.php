<?php
     session_start();
    if (isset($_POST['btnNext'])) {
        $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='fGoods'AND `type`='finished product' GROUP BY `item_no`,`type`;";
          $_SESSION['cno']=$_POST['txtCNO'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $rowSQL3= mysqli_query( $con,$sql);
          $m="";
          $count=0;
            $count2=0;
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            if(isset($_POST[$row3['item_no']])){
              $count++;
              $m=$m.$row3['item_no'].'x'.$_POST['txt'.$row3['item_no']].',';
                if($_POST['txt'.$row3['item_no']]>0){
                $count2++;
            }
            }
          }
        if($count==0){
            header('Location:../Pages/createInvoice.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/createInvoice.php?count2=0');
        }else {
          $_SESSION['INVOICE']=$m;
          header('Location:../Pages/confirmInvoice.php');
        }
        }