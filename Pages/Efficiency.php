<?php
  session_start();
  require '../PHPScripts/Efficiency.php';
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/efStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>viewEfficiency</title>
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
                <a href="selectEf.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class="section-view">
      <?php
        $depts=['store', 'pFloor', 'fGoods'];
        foreach ($depts as $d){
          if (isset($_GET['y']) && isset($_GET['m'])){
            $eff= getDeptEfficiencyMonthly($dept=$d, $y=$_GET['y'], $m=$_GET['m']);
          }elseif (isset($_GET['y']) && !isset($_GET['m'])){
            $eff= getDeptEfficiencyYearly($dept=$d, $y=$_GET['y']);
          }else{
            $eff= getDeptEfficiencyFull($dept=$d);
          }
          processEfficiency($eff, $d);
        }
        for ($i=1; $i < sizeof($depts); $i++) {
          if (isset($_GET['y']) && isset($_GET['m'])){
            $eff= getTransferEfficiencyMonthly($fromDept=$depts[$i-1], $toDept=$depts[$i], $y=$_GET['y'], $m=$_GET['m']);
          }elseif (isset($_GET['y']) && !isset($_GET['m'])){
            $eff= getTransferEfficiencyYearly($fromDept=$depts[$i-1], $toDept=$depts[$i], $y=$_GET['y']);
          }else{
            $eff= getTransferEfficiencyFull($fromDept=$depts[$i-1], $toDept=$depts[$i]);
          }
          processTransferEfficiency($eff, $depts[$i-1], $depts[$i]);
        }
      ?>
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
<!--dan-->
