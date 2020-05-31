<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }elseif ($_SESSION['DES']!='Manager') {
      header('Location:empHome.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Debtors</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
</head>
<body>
  <header>
  <div class="row">
      <h1>Manufacturing Management System</h1>
      <h3>Galleon Lanka PLC</h3>
  </div>
  <div class="nav">
      <div class="row">
          <div class="btn-navi"><i class="ion-navicon-round"></i></div>
          <a href="empHome.php">
              <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
          </a>
          <a href="logout.php">
              <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
          </a>
          <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
      </div>
  </div>
  </header>

    <section class="section-manage">
        <div class="row">
          <div class="col span-1-of-7">
          </div>
          <div class="col span-6-of-7">
    <form action="viewDebtors.php">
    <table>
    <tr>
        <th>
          CNo
        </th>
        <th>
          Total Amount
        </th>
        <th>
          Date
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
  </div>
</div>
</section>
<footer>
  <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
  <div class="row"><p>Designed and Developed by DGS2</p></div>
</footer>
</body>
</html>
<!--sithara-->
