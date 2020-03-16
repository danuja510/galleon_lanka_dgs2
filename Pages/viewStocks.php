<?php
session_start();
if(!isset($_SESSION['eno']))
{
  header('Location:signIn.php');
}
else if(!isset($_SESSION['DES']))
{
  header('Location:signIn.php');
}
else if(!isset($_SESSION['DEPT']))
{
  header('Location:signIn.php');
}
$des=$_SESSION['DES'];
$dep=$_SESSION['DEPT'];

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>view stocks</title>
  </head>
  <body>
    <label for="lblDept">
        your Department:
    </label>
    <label>
      <?php
        echo "$dep";
      ?>
    </label>

    <table border="1">
      <thead>
        <td>Department</td>
        <td>item no</td>
        <td>qty</td>
      </thead>

      <?php
      $con=mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }
      if($dep=="Manager")
      {
      $sql="SELECT dept,item_no,SUM(qty) as finalstock FROM `stocks` GROUP BY dept,item_no;";
      }

      if($dep=="store")
      {
      $sql="SELECT dept,item_no,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='store' GROUP BY dept,item_no;";
      }

      if($dep=="pfloor")
      {
      $sql="SELECT dept,item_no,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='pfloor' GROUP BY dept,item_no;";
      }

      if($dep=="fGoods")
      {
      $sql="SELECT dept,item_no,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='fGoods' GROUP BY dept,item_no;";
      }
      $rowSQL= mysqli_query($con,$sql);
      while($row=mysqli_fetch_assoc($rowSQL))
      {
echo"
      <tr>
        <td>".$row['dept']."</td>
        <td>".$row['item_no']."</td>
        <td>".$row['finalstock']."</td>
      </tr>
";
      }
    ?>
    </table>

  </body>
</html>



<!--gima-->
