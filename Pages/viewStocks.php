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
    
      <tr>
        <td>store</td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td>p Floor</td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td>F goods</td>
        <td></td>
        <td></td>
      </tr>
    </table>

  </body>
</html>



<!--gima-->
