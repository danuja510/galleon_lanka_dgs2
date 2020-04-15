<?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='pfloor'AND `type`='material' GROUP BY `item_no`,`type`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        $m="";
        while($row=mysqli_fetch_assoc( $rowSQL )){
          $m=$m.$row['item_no'].'x'.($row['Qty']-$_POST['txt'.$row['item_no']]).',';
        }
      $_SESSION['ifg_us']=$m;
      header('Location:../Pages/confirmIFG.php');
    }