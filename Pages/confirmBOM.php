<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DES']!='Manager') {
    header('Location:empHome.php');
  }elseif (!isset($_SESSION['bom'])) {
    header('Location:addBOM.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>confirmBOM</title>
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
                <a href="addBOM.php">
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
            <div class='col span-2-of-2'>
                <table>
      <thead>
        <th>Material Name</th>
        <th>Quantity</th>
      </thead>
      <?php
        for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
          $bom=explode(',',$_SESSION["bom"][$i]);
          echo "
          <tr>
            <td>".$bom[0]."</td>
            <td>".$bom[1]."</td>
          </tr>
          ";
        }
      ?>
      <tr>
        <td class="bt">&nbsp;</td>
        <form action="../PHPScripts/confirmBOMScript.php" method="post">
          <td class="bt"><input type='submit' value='Confirm' id='btnConfirm' name='btnConfirm'>
              <button type='submit' id='btnNext' name='btnNext'>Back</button>
              <input type='submit' id='btnDelete' name='btnDelete' value='Reset'></td>
        </form>
      </tr>
    </table>
            </div>
        </div>
      </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>
<!--dan-->
