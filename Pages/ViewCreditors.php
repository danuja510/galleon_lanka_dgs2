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
        $sql="SELECT * FROM `creditors`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);

        while($row = mysqli_fetch_assoc( $rowSQL ))
        {
          echo "<tr>";
          //echo "<td>" . $row['crid'] . "</td>";
          echo "<td>" . $row['sid'] . "</td>";
          echo "<td>" . $row['amount'] . "</td>";
          echo "<td>" . $row['date'] . "</td>";
          echo "</tr>";

          if ($row['state']== 'active')
            {
              echo "<td>" . "<input type ='submit' id = 'btnUpdate".$row['sid'] ."' name='btnUpdate".$row['sid'] ."' value= 'Update Supplier'> ";

              echo "<td>" . "<input type ='submit' id= 'btnDelete".$row['sid'] ."' name='btnDelete".$row['sid'] . "'value= 'Delete Supplier'>". "</td>";
            }
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
  $sql2="SELECT * FROM `creditors`;";
  $rowSQL= mysqli_query( $con,$sql2);
  mysqli_close($con);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    if(isset($_POST['btnUpdate'.$row['sid']]))
    {
      $_SESSION['creditors']=$row['sid'];
      header('Location:updateCreditorsPage.php');
    }

    if(isset($_POST['btnDelete'.$row['sid']]))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Eror while connecting to database");
      }

      $sql2="UPDATE `creditors` SET `state` = 'inactive' WHERE `creditors`.`sid`=".$row['sid'].";";
      mysqli_query($con,$sql2);
      mysqli_close($con);
      header('Location:ViewCreditors.php');
    }
  }
?>
</html>

<!--jini-->
