<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }else if (!isset($_SESSION['dept'])) {
   header('Location:createGTN.php');
 }else if (!isset($_SESSION['gtntype'])) {
   header('Location:createGTN.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>stocksForGTN</title>
  </head>
  <body>
    <form action="stocksForGTN.php" method="post">
      <table>
        <thead>
          <th>Item No.</th>
          <th>Type</th>
          <th>Available Qty.</th>
          <th>Qty. to be transfered <?php echo $_SESSION['gtntype']; ?></th>
          <th></th>
        </thead>
        <?php
          $type=$_SESSION['gtntype'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          if($_SESSION['gtntype']=='out'){
            if ($_SESSION['dept']=='store') {
              $sql="SELECT * FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' AND `type`='material';";
              $iType='material';
            }elseif ($_SESSION['dept']=='pfloor') {
              $sql="SELECT * FROM `stocks` WHERE `dept`='".$_SESSION['dept']."'AND `type`='finished product';";
              $iType='finished product';
            }
            $rowSQL= mysqli_query( $con,$sql);
            while($row=mysqli_fetch_assoc( $rowSQL )){
              echo "
                <tr>
                  <td>".$row['item_no']."</td>
                  <td>".$row['type']."</td>
                  <td>".$row['qty']."</td>
                  <td><input type='number' id='txt".$row['item_no']."' name='txt".$row['item_no']."' step='1' min='0' max='".$row['qty']."' value='0'></td>
                  <td><input type='checkbox' name='".$row['item_no']."' value='".$row['item_no']."' ></td>
                </tr>
              ";
            }
          }else {
            if ($_SESSION['dept']=='pfloor') {
              $sql="SELECT * FROM `materials`;";
              $rowSQL= mysqli_query( $con,$sql);
              $iType='material';
              while($row=mysqli_fetch_assoc( $rowSQL )){
                echo "
                  <tr>
                    <td>".$row['mid']."</td>
                    <td>".$iType."</td>
                    <td>-</td>
                    <td><input type='number' id='txt".$row['mid']."' name='txt".$row['mid']."' step='1' min='0' value='0'></td>
                    <td><input type='checkbox' name='".$row['mid']."' value='".$row['mid']."' ></td>
                  </tr>
                ";
              }
            }
            if ($_SESSION['dept']=='fGoods') {
              $sql="SELECT * FROM `finished_products`;";
              $rowSQL= mysqli_query( $con,$sql);
              $iType='finished product';
              while($row=mysqli_fetch_assoc( $rowSQL )){
                echo "
                  <tr>
                    <td>".$row['fp_id']."</td>
                    <td>".$iType."</td>
                    <td>-</td>
                    <td><input type='number' id='txt".$row['fp_id']."' name='txt".$row['fp_id']."' step='1' min='0' value='0'></td>
                    <td><input type='checkbox' name='".$row['fp_id']."' value='".$row['fp_id']."' ></td>
                  </tr>
                ";
              }
            }
          }
          mysqli_close($con);
        ?>
      </table>
      <input type="submit" name="btnNext" id="btnNext" value="Next">
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        if ($_SESSION['gtntype']=='out') {
          $rowSQL3= mysqli_query( $con,$sql);
          $m=$type."+";
          $count=0;
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            if(isset($_POST[$row3['item_no']])){
              $count++;
              $m=$m.$row3['item_no'].'x'.$_POST['txt'.$row3['item_no']].'x'.$iType.',';
            }
          }
        }else {
          if ($_SESSION['dept']=='pfloor') {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$type."+";
            $count=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['mid']])){
                $count++;
                $m=$m.$row3['mid'].'x'.$_POST['txt'.$row3['mid']].'x'.$iType.',';
              }
            }
          }
          if ($_SESSION['dept']=='fGoods') {
            $rowSQL3= mysqli_query( $con,$sql);
            $m=$type."+";
            $count=0;
            while($row3=mysqli_fetch_assoc( $rowSQL3 )){
              if(isset($_POST[$row3['fp_id']])){
                $count++;
                $m=$m.$row3['fp_id'].'x'.$_POST['txt'.$row3['fp_id']].'x'.$iType.',';
              }
            }
          }
        }
        if($count==0){
          echo "
          <script type='text/javascript'>
            alert('Select A Items to Transfer');
            event.preventDefault();
          </script>
          ";
        }else {
          $_SESSION['GTN']=$m;
          header('Location:confirmGTN.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
