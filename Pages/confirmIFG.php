<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['ifg'])) {
    header('Location:inputFinishedGoods.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>confirmIFG</title>
  </head>
  <body>
    <table>
      <thead>
        <th>Finished Product ID</th>
        <th>Finished Product Name</th>
        <th>Qty. to be Inserted</th>
        <th></th>
      </thead>
      <?php
      $query=[];
      $query2=[];
      $ifg=$_SESSION['ifg'];
      $ifgs=explode(',',$ifg);
      $count=0;
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      for ($i=0; $i <sizeof($ifgs)-1 ; $i++) {
        $order=explode('x',$ifgs[$i]);
        if ($order[1]==0) {
        }else {
          $count++;
          $sql="SELECT * FROM `finished_products` WHERE `fp_id` = ".$order[0].";";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          echo "
            <tr>
              <td>
                ".$order[0]."
              </td>
              <td>
                ".$row['Name']."
              </td>
              <td>
                ".$order[1]."
              </td>
            </tr>
          ";
            $query[$i]="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$order[0]."', '".$order[1]."', 'finished product', CURDATE(), 'pfloor');";

        }
      }
      ?>
    </table>
    <table>
      <thead>
        <th>Material ID</th>
        <th>Updated Qty.</th>
      </thead>
      <?php
        $ifg_us=$_SESSION['ifg_us'];
        $ifg_uss=explode(',',$ifg_us);
        for ($i=0; $i <sizeof($ifg_uss)-1 ; $i++) {
          $order=explode('x',$ifg_uss[$i]);
          $sql4="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='pfloor'AND `item_no`=".$order[0]." AND `type`='material' GROUP BY `item_no`,`type`;";
          $rowSQL4= mysqli_query( $con,$sql4);
          $row4 = mysqli_fetch_array( $rowSQL4 );
          echo "
            <tr>
              <td>
                ".$order[0]."
              </td>
              <td>
                ".($row4['Qty']-$order[1])."
              </td>
            </tr>
          ";
          $query2[$i]="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$order[0]."', '".-$order[1]."', 'material', CURDATE(), 'pfloor');";
          }
        mysqli_close($con);
      ?>
    </table>
    <form action="confirmIFG.php" method="post">
      <input type="submit" name="btnConfirm" value="Confirm">
    </form>
    <?php
      if (isset($_POST['btnConfirm'])) {
        //updating/inserting finished goods to stocks
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i <sizeof($query) ; $i++) {
          mysqli_query( $con,$query[$i]);
        }
        for ($i=0; $i <sizeof($query2) ; $i++) {
          mysqli_query( $con,$query2[$i]);
        }
        mysqli_close($con);
      }
    ?>
  </body>
</html>
<!--dan-->
