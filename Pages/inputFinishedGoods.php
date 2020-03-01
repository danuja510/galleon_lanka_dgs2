<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>InputFinishedGoods</title>
  </head>
  <body>
    <form action="InputFinishedGoods.php" method="post">
      <table>
        <thead>
          <th>Finished Product ID</th>
          <th>Finished Product Name</th>
          <th>Qty. to be Inserted</th>
          <th></th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `finished_products`;";
          $rowSQL= mysqli_query( $con,$sql);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            echo "
              <tr>
                <td>".$row['fp_id']."</td>
                <td>".$row['Name']."</td>
                <td><input type='number' id='txt".$row['fp_id']."' name='txt".$row['fp_id']."' step='1' min='0' value='0'></td>
                <td><input type='checkbox' name='".$row['fp_id']."' value='".$row['fp_id']."' ></td>
              </tr>
            ";
          }
        ?>
      </table>
      <input type="submit" name="btnNext" id="btnNext" value="Next">
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $rowSQL3= mysqli_query( $con,$sql);
        mysqli_close($con);
        $m="";
        $count=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['fp_id']])){
            $count++;
            $m=$m.$row3['fp_id'].'x'.$_POST['txt'.$row3['fp_id']].',';
          }
        }
        if($count==0){
          echo "
          <script type='text/javascript'>
            alert('Select A Finished Good to be inserted');
            event.preventDefault();
          </script>
          ";
        }else {
          $_SESSION['ifg']=$m;
          header('Location:updateStock.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
