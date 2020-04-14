<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>view debtors</title>
</head>
<body>
    <form action="viewDebtors.php">
    <table>
    <tr>
        <th>
          cno
        </th>
        <th>
          total amount
        </th>
        <th>
          date
        </th>
    </tr>

    <?php
    $con=mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
      {
        die("cannot connect to DB server");
      }

      $sql="SELECT *,SUM(amount) AS tot FROM `debtors` GROUP BY `cno`";
      $rowSQL=mysqli_query($con,$sql);
      while($row=mysqli_fetch_array($rowSQL))
      {
echo"
  <tr>
      <td>
          ".$row['cno']."
      </td>
      <td>
          ".$row['tot']."
      </td>
      <td>
          ".$row['date']."
      </td>
  </tr>
";
      }
  ?>
  </table>
  </form>

</body>
</html>
<!--sithara-->
