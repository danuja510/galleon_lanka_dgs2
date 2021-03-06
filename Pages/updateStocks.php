<?php
session_start();

require '../PHPScripts/stock.php';

if(!isset($_SESSION['eno']))
{
  header('Location:signIn.php');
}elseif ($_SESSION['DES']!='Manager') {
  header('Location:empHome.php');
}
else if(!isset($_SESSION['DES']))
{
  header('Location:signIn.php');
}
else if(!isset($_SESSION['DEPT']))
{
  header('Location:signIn.php');
}
$des=$_SESSION['DES'];
$dep=$_SESSION['DEPT'];
$op="";
if(isset($_GET['sort'])){
    switch ($_GET['sort']){
        case 'store':$op = "<option value='".$_GET['sort']."'>Store</option>";break;
        case 'pFloor':$op = "<option value='".$_GET['sort']."'>Production Floor</option>";break;
        case 'fGoods':$op = "<option value='".$_GET['sort']."'>Finished Goods</option>";break;
    }
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update Balance Stocks</title>
    <link rel="stylesheet" type="text/css" href="../StyleSheets/viewStocksStyles.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/viewStocksStyles.css">
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
                <!-- <div class="btn-navi"><i class="ion-navicon-round"></i></div> -->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="viewStocks.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
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
          <form action="../PHPScripts/updateStocksScript.php" method="post">
            <div class="col span-1-of-7">
                    <div class="new">
                    Your Department:
                    <?php
                    echo "<p style='text-transform: capitalize;'><b>$dep</b></p><br>";
                    ?>
              <br>
                <?php
                if($dep=="Manager")
                {
            echo"
                    Sort by Department:
                <select name='lstDepartment'>
                    ".$op."
                  <option value='all'>All</option>
                  <option value='store'>Store</option>
                  <option value='pFloor'>Production floor</option>
                  <option value='fGoods'>Finished Goods</option>
                </select>
                <input type='submit' name='btnSort' value='Sort'>
            ";
                }
                 ?>
                    </div>
        </div>
          </form>
            <div class="col span-6-of-7">
        <table>
          <thead>
            <thead>
              <th>Item Name</th>
              <th>qty</th>
              <th>type</th>
              <th>Department</th>
            </thead>
          </thead>
          <?php
            $get="";
            if(isset($_GET['sort'])){
              $get="?sort=".$_GET['sort'];
            }
            echo "<form action='../PHPScripts/updateStocksScript.php".$get."' method='post'>";
           ?>
          <?php

          $departments =array('store', 'fGoods', 'pFloor');
          if(isset($_GET['sort']) && in_array($_GET['sort'], $departments)){
              $stockArr=viewStocksManagerFiltered($sort=$_GET['sort']);
          }else {
            $stockArr=viewStocksManager();
          }

          foreach ($stockArr as $stock) {
       echo"
          <tr>
            <td>".$stock->item_name."</td>
            <td>".$stock->type."</td>
            <td><input type='number' name='txt".$stock->dept."".$stock->type."".$stock->item_name."' id='txt".$stock->dept."".$stock->type."".$stock->item_name."' min=0 required></td>
            <td>".$stock->dept."</td>
          </tr>";
          }
          echo "
          <tr>
            <td class='bt'>&nbsp;</td>
            <td class='bt'>&nbsp;</td>
            <td class='bt'>&nbsp;</td>
            <td class='bt'><input type='submit' name='btnUpdate' id='btnUpdate' value='Update'></td>
          </tr>";
        ?>
        </table>
        </div>
    </form>
        </div>
      </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>
<!--gima-->
