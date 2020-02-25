<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
 ?>
 <html>
 <head>
   <meta charset="utf-8">
   <title align="center">View Supplier</title>
  <head>
  <body>
    <form action="ViewSuppliers.php" method="post">
      <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6EAF8">
        <thread>
          <tr>
          <th align="center" > Supplier ID </th>
          <th align="center" > Name </th>
          <th align="center" > Address </th>
          <th align="center" > Telephone No. </th>
          </tr>
        </thread>

        <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `supplier` GROUP BY `sid`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);

        while($row = mysqli_fetch_array($result))
        {
          echo "<tr>";
          echo "<td>" . $row['sid'] . "</td>";
          echo "<td>" . $row['Name'] . "</td>";
          echo "<td>" . $row['Address'] . "</td>";
          echo "<td>" . $row['tpno'] . "</td>";
          echo "<td>" ." <input type='submit' name='".$row['cno']."' value='view'>". "</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </form>
</body>
<?php
  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
    die("Error while connecting to database");
  }
  $sql="SELECT * FROM `supplier` GROUP BY `sid`;";
  $rowSQL= mysqli_query( $con,$sql);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    if(isset($_POST[$row['sid']])){
      $_SESSION['supplier']=$row['sid'];
      header('Location:viewSupplierPage.php');
    }
  }
?>
</html>

--jini--
