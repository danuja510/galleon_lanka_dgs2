<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DES']!='Manager') {
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/SignInStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>selectEfficiency</title>
  </head>
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
    <section>
        <div class='row'>
            <?php
              $con=mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con){
                die("Cannot connect to DB server");
              }
              $sql="select extract(year from date) as yr from stocks group by extract(year from date);";
              $rowSQL= mysqli_query( $con,$sql);
              if (mysqli_num_rows($rowSQL)>0) {
                echo "<div class='col span-1-of-3'>
                    <h3><strong>Full Efficiency</strong></h3>
                    <a class='links' href='Efficiency.php'>Full Efficiency</a>
                </div>
                <div class='col span-1-of-3'>
                    <h3><strong>Yearly Efficiency</strong></h3>";
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "
                          <a class='links' href='Efficiency.php?y=".$row['yr']."'> Efficiency of ".$row['yr']."</a><br>
                        ";
                      }
                      echo "
                </div>
                <div class='col span-1-of-3'>
                    <h3><strong>Monthly Efficiency</strong></h3>";
                        $sql="select extract(year from date) as yr, extract(month from date) as mon from stocks group by extract(year from date), extract(month from date) order by yr, mon;";
                        $rowSQL= mysqli_query( $con,$sql);
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "
                          <a class='links' href='Efficiency.php?y=".$row['yr']."&m=".$row['mon']."'> Efficiency of ".$row['mon']."/".$row['yr']."</a><br>
                        ";
                      }
                    mysqli_close($con);
                echo "</div>";
              }else {
                echo "<h2>NO OPERATIONS HAS BEEN CARRIED OUT</h2>";
              }
             ?>
        </div>
    </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
      </footer>
  </body>
</html>
<!--dan-->
