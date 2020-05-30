<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='pFloor'){
   header('Location:empHome.php');
 }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
   <title>View Customer</title>
  <head>
  <body>
     <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="empHome.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class = "section-manage">
      <div class = "row">
        <div class ="col span-1-of-6">
          <a href="addCustomer.php">
            <div class="new">
              <i class="ion-ios-compose-outline"></i>
              New Customer
            </div>
          </a>
        </div>
        <div class="col span-5-of-6">
          <form action="../PHPScripts/ViewCustomerScript.php" method="post">
            <table>
              <thead><th>Customer Number</th><th> Name </th><th> Address </th><th> Telephone No. </th><th> Customer Type </th><th> State </th><th class="bt">&nbsp;</th></thead>
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
                echo "<tr><td>" . $row['cno'] . "</td><td>" . $row['Name'] . "</td><td>" . $row['Address'] . "</td><td>" . $row['tpno'] . "</td><td>" . $row['type'] . "</td><td>" . $row['state'] . "</td>";
                echo "<td>" ." <input type='submit' id='btnUpdate".$row['cno'] ."'  name='btnUpdate".$row['cno'] ."' value='view'> ";
                echo "</tr>";
              }
            ?>
          </table>
        </form>
        </div>
      </div>
    </section>

  <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
</body>
</html>


<!--jini-->
