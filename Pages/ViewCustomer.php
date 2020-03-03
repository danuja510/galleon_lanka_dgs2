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
   <title>View Customer</title>
  <head>
  <body>
    <form action="ViewCustomer.php" method="post">
      <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6EAF8">
        <thread>
          <tr>
          <th align="center" > Customer Number </th>
          <th align="center" > Name </th>
          <th align="center" > Address </th>
          <th align="center" > Telephone No. </th>
          <th align="center" > Customer Type </th>

        </tr>
        </thread>

        <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `customer` ;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);

        while($row = mysqli_fetch_assoc($rowSQL))
        {
          echo "<tr>";
          echo "<td>" . $row['cno'] . "</td>";
          echo "<td>" . $row['Name'] . "</td>";
          echo "<td>" . $row['Address'] . "</td>";
          echo "<td>" . $row['tpno'] . "</td>";
          echo "<td>" . $row['type'] . "</td>";

          if ($row['state'] =='active') {
          echo "<td>" ." <input type='submit' id='btnUpdate".$row['cno'] ."'  name='btnUpdate".$row['cno'] ."' value='Update Customer'> ";

          echo "<td>" ."<input type='submit' name='btndelete".$row['cno'] ."' id='btndelete".$row['cno'] ."' value= 'Delete Customer' ". "</td>";

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
    $sql2="SELECT * FROM `customer` ;";
    $rowSQL= mysqli_query( $con,$sql2);
    mysqli_close($con);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      if(isset($_POST['btnUpdate'.$row['cno']])){
        $_SESSION['customer']=$row['cno'];
        header('Location:updateCustomerPage.php');
      }


    if(isset($_POST['btndelete'.$row['cno']]))
    {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql2="UPDATE `customer` SET `state` = 'inactive' WHERE `customer`.`cno`=".$row['cno'].";";
      mysqli_query($con,$sql2);
      mysqli_close($con);
      header('Location:ViewCustomer.php');
    }
}

?>
</html>


<!--jini-->
