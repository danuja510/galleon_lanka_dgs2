<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif (!isset($_SESSION['bom'])) {
    header('Location:addBOM.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>confirmBOM</title>
  </head>
  <body>
    <table>
      <thead>
        <th>Material Name</th>
        <th>Quantity</th>
      </thead>
      <?php
        for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
          $bom=explode(',',$_SESSION["bom"][$i]);
          echo "
          <tr>
            <td>".$bom[0]."</td>
            <td>".$bom[1]."</td>
          </tr>
          ";
        }
      ?>
      <tr>
        <td class="bt">&nbsp;</td>
        <form action="confirmBOM.php" method="post">
          <td class="bt"><input type='submit' value='Confirm' name='btnConfirm'></td>
        </form>
      </tr>
    </table>
    <?php
    if (isset($_POST['btnConfirm'])) {
      $con=mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con){
        die("Cannot connect to DB server");
      }
      $rowSQL = mysqli_query( $con,"SELECT MAX( bom_id ) AS max FROM `bom`;" );
      $row = mysqli_fetch_array( $rowSQL );
      $max = $row['max'];
      $bom_id=$max+1;
      for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
        $bom=explode(',',$_SESSION["bom"][$i]);
        $sql="INSERT INTO `bom` (`no`, `bom_id`, `mName`, `qty`, `state`) VALUES (NULL, '".$bom_id."', '".$bom[0]."', '".$bom[1]."', 'active');";
        mysqli_query( $con, $sql);
      }
      mysqli_close($con);
      unset($_SESSION["bom"]);
      header('Location:manageBOM.php');
    }
    ?>
  </body>
</html>
<!--dan-->
