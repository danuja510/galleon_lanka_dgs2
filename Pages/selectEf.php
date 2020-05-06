<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DES']!='Manager') {
    header('Location:empHome.php');
  }
  
  $sql="select extract(year from date) as yr, extract(month from date) as mon from stocks group by extract(year from date), extract(month from date) order by yr, mon;";
  $con=mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con){
    die("Cannot connect to DB server");
  }
  $rowSQL= mysqli_query( $con,$sql);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>selectEfficiency</title>
  </head>
  <body>
    <h3>Monthly Efficiency</h3>
    <?php
      while($row=mysqli_fetch_assoc( $rowSQL )){
        echo "
          <a href='viewEfficiency.php?y=".$row['yr']."&m=".$row['mon']."'> Efficiency of ".$row['mon']."/".$row['yr']."</a><br>
        ";
      }
    ?>
    <h3>Yearly Efficiency</h3>
    <?php
      $sql="select extract(year from date) as yr from grn group by extract(year from date);";
      $rowSQL= mysqli_query( $con,$sql);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        echo "
          <a href='viewEfficiency.php?y=".$row['yr']."'> Efficiency of ".$row['yr']."</a><br>
        ";
      }
      mysqli_close($con);
    ?>
    <h3>Full Efficiency</h3>
    <a href="viewEfficiency.php">Full Efficiency</a>
  </body>
</html>
