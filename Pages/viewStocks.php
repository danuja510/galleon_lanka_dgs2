<?php
session_start();

require '../PHPScripts/stock.php';

if(!isset($_SESSION['eno']))
{
  header('Location:signIn.php');
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
    <title>view stocks</title>
    <link rel="stylesheet" type="text/css" href="../StyleSheets/viewStocksStyles.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
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
                <!-- <div class="btn-navi"><i class="ion-navicon-round"></i></div> -->
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
      <section class="section-manage">
        <div class="row">
            <form action="../PHPScripts/viewStocksScript.php" method="post">
            <div class="col span-1-of-7">
                    <div class="new">
                    Your Department:
                    <?php
                    if($dep=="Manager")
                    {
                      $departments =array('store', 'fGoods', 'pFloor');
                      if(isset($_GET['sort']) && in_array($_GET['sort'], $departments)){
                          $stockArr=viewStocksManagerFiltered($sort=$_GET['sort']);
                      }else {
                        $stockArr=viewStocksManager();
                      }
                    }else {
                      $stockArr=viewStocksEmployee($dep=$dep);
                    }
                    echo "<p style='text-transform: capitalize;'><strong>$dep</strong></p><br>";
                    echo "Total Value of stocks:<br>";
                    $tot=0;
                    foreach ($stockArr as $stock){
                      $tot+=$stock->total_value;
                    }
                    echo "<strong>".round($tot,2)."</strong><br>";
                    ?>
              <br>
                <?php
                if($dep=="Manager")
                {
            echo"
                    Sort by Department:
                <select name='lstDepartment' id='lstDepartment'>
                    ".$op."
                  <option value='all'>All</option>
                  <option value='store'>Store</option>
                  <option value='pFloor'>Production floor</option>
                  <option value='fGoods'>Finished Goods</option>
                </select>
                <input type='submit' name='btnSort' value='Filter'>
                <br>&nbsp;<br><br>
            ";
                }
                if ($_SESSION['DEPT']== 'Manager' || $_SESSION['DEPT']== 'pFloor') {
                  echo "<a href='inputFinishedGoods.php'><b class='ifg'>Input Finished Goods</b></a><br><br>";
                  if ($_SESSION['DEPT']== 'Manager') {
                    echo "<a href='updateStocks.php'><b class='ifg'>Update Monthly Balance Stocks</b></a><br><br>";
                  }
                }
                 ?>
                    </div>
        </div>
            <div class="col span-6-of-7">
        <table>
          <thead>
            <th>Item Name</th>
            <th>qty</th>
            <th>type</th>
            <th>Department</th>
            <th>Value</th>
          </thead>

          <?php
            foreach ($stockArr as $stock) {
              echo"
                    <tr>
                      <td>".$stock->item_name."</td>
                      <td>".$stock->qty."</td>
                      <td>".$stock->type."</td>
                      <td>".$stock->dept."</td>
                      <td>".round($stock->total_value,2)."</td>
                    </tr>
              ";
            }
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
