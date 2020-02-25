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
          <th>Qty. to be transfered</th>
          <th></th>
        </thead>
        <?php
          $type=$_SESSION['gtntype'];
          $sql="SELECT * FROM `stocks` WHERE `dept`='".$_SESSION['dept']."';";
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
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
        $rowSQL3= mysqli_query( $con,$sql);
        $m=$type."+";
        $count=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['item_no']])){
            $count++;
            $m=$m.$row3['item_no'].'x'.$_POST['txt'.$row3['item_no']].'x'.$row3['type'].',';
          }
        }
        if($count==0){
          echo "
          <script type='text/javascript'>
            alert('Select A Material to Order');
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
