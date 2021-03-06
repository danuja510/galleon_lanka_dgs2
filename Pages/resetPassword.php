<?php
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reset pwd</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
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

      <section class="section-view">
        <h2>Reset Password</h2>
      <form action="../PHPScripts/resetPasswordScript.php" method="post">
        <div class="row">
    <table>
      <div class="row">
        <div class="col span-1-of-2">
            <label for="txtEno">
                Eno
            </label>
        </div>
        <div class="col span-1-of-2">
            <input type="text" name="txtEno" id="txtEno" value="" required>
        </div>
      </div>

      <div class="row">
        <div class="col span-1-of-2">
            <label for="txtEmail">
                Email
            </label>
        </div>
        <div class="col span-1-of-2">
            <input type="email" name="txtEmail" id="txtEmail" value="" required>

        </div>
      </div>

      <div class='row'>
        <div class="col span-1-of-2"></div>
        <div class="col span-1-of-2">
          <?php
            if(isset($_GET['s'])){
              echo "&nbsp";
              echo "Invalid Crediantials";
              unset($_GET['s']);
            }
          ?>
        </div>
      </div>

      <div class='row'>
        <div class='col span-1-of-2'></div>
        <div class='col span-1-of-2'>
          <input type="Submit" name="btnSubmit" id="btnSubmit" value="Submit" onclick="Validate()">
          <input type="Reset" name="btnReset" id="btnReset" value="Reset">
        </div>
      </div>
    </table>
    </form>
  </section>

  <footer>
      <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
      <div class="row"><p>Designed and Developed by DGS2</p></div>
  </footer>

  </body>
</html>
<!--sithara-->
