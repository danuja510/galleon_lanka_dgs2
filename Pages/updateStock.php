<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<!--dan-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>updateStock</title>
  </head>
  <body>
    <form action="updateStock.php" method="post">
      <table>
        <thead>
          <th>Material ID</th>
          <th>Updated Qty.</th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='pfloor'AND `type`='material' GROUP BY `item_no`,`type`;";
          $rowSQL= mysqli_query( $con,$sql);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            echo "
              <tr>
                <td>".$row['item_no']."</td>
                <td><input type='number' id='txt".$row['item_no']."' name='txt".$row['item_no']."' step='1' min='0' max='".$row['Qty']."' value='".$row['Qty']."'></td>
              </tr>
            ";
          }
        ?>
      </table>
      <input type="submit" name="btnNext" id="btnNext" value="Next">
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        $m="";
        while($row=mysqli_fetch_assoc( $rowSQL )){
          $m=$m.$row['item_no'].'x'.($row['Qty']-$_POST['txt'.$row['item_no']]).',';
        }
      $_SESSION['ifg_us']=$m;
      header('Location:confirmIFG.php');
    }
    ?>
  </body>
</html>
