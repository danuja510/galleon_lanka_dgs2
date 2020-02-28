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
   <title align="center">View Creditors</title>
  <head>
  <body>
    <form action="ViewCreditors.php" method="post">
      <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6EAF8">
        <thread>
          <tr>
          <th align="center" > Creditor ID </th>
          <th align="center" > Supplier ID </th>
          <th align="center" > Amount </th>
          <th align="center" > Date </th>
          </tr>
        </thread>

        <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `creditors` GROUP BY `crid`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);

        while($row = mysqli_fetch_assoc( $rowSQL ))
        {
          echo "<tr>";
          echo "<td>" . $row['crid'] . "</td>";
          echo "<td>" . $row['sid'] . "</td>";
          echo "<td>" . $row['amount'] . "</td>";
          echo "<td>" . $row['date'] . "</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </form>
</body>
</html>

<!--jini-->
