<?php
 session_start();
 require '../PHPScripts/stock.php';

 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif (!isset($_SESSION['dept'])) {
   header('Location:createGTN.php');
 }else if (!isset($_SESSION['gtntype'])) {
   header('Location:createGTN.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>stocksForGTN</title>
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
                <a href="GTNType.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <?php echo "<h2 class='gtn'>Department : ".$_SESSION['dept']."</h2><h2 class='gtn'>GTN Type : ".$_SESSION['gtntype']."</h2>"; ?>
    <section class="section-select2">
      <div class="row">
        <div class="col span-2-of-2">
          <form action="../PHPScripts/stocksForGTNScript.php" method="post">
            <table>
              <thead><th>Item Name</th><th>Type</th><th>Available Qty.</th><th>Qty</th><th class="bt">&nbsp;</th>
              </thead>
              <?php
                $type=$_SESSION['gtntype'];
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                if($_SESSION['gtntype']=='out' || $_SESSION['gtntype']=='return_out'){
                  if ($_SESSION['dept']=='pFloor') {
                    if ($_SESSION['gtntype']=='out') {
                      $stockArr= viewStocksEmployee($dept='pFloor');
                      foreach ($stockArr as $stock){
                        if ($stock->type=='finished_product') {
                          echo "<tr>
                                  <td>".$stock->item_name."</td>
                                  <td>".$stock->type."</td>
                                  <td>".$stock->qty."</td>
                                  <td><input type='number' id='txt".$stock->item_name."".$stock->type."' name='txt".$stock->item_name."".$stock->type."' step='1' min='0' max='".$stock->qty."' value='0'></td>
                                  <td class='chk'><input type='checkbox' id='".$stock->item_name."".$stock->type."' class='css-checkbox' name='".$stock->item_name."".$stock->type."' value='".$stock->item_name."'><label class='css-label' for='".$stock->item_name."".$stock->type."'>&nbsp;</label></td>
                              </tr>";
                        }
                      }
                    }elseif ($_SESSION['gtntype']=='return_out') {
                      $stockArr= viewStocksEmployee($dept='pFloor');
                      foreach ($stockArr as $stock){
                        if ($stock->type=='material') {
                          echo "<tr>
                                  <td>".$stock->item_name."</td>
                                  <td>".$stock->type."</td>
                                  <td>".$stock->qty."</td>
                                  <td><input type='number' id='txt".$stock->item_name."".$stock->type."' name='txt".$stock->item_name."".$stock->type."' step='1' min='0' max='".$stock->qty."' value='0'></td>
                                  <td class='chk'><input type='checkbox' id='".$stock->item_name."".$stock->type."' class='css-checkbox' name='".$stock->item_name."".$stock->type."' value='".$stock->item_name."'><label class='css-label' for='".$stock->item_name."".$stock->type."'>&nbsp;</label></td>
                              </tr>";
                        }
                      }
                    }
                  }else {
                    $stockArr= viewStocksEmployee($dept=$_SESSION['dept']);
                    foreach ($stockArr as $stock){
                      echo "<tr>
                              <td>".$stock->item_name."</td>
                              <td>".$stock->type."</td>
                              <td>".$stock->qty."</td>
                              <td><input type='number' id='txt".$stock->item_name."".$stock->type."' name='txt".$stock->item_name."".$stock->type."' step='1' min='0' max='".$stock->qty."' value='0'></td>
                              <td class='chk'><input type='checkbox' id='".$stock->item_name."".$stock->type."' class='css-checkbox' name='".$stock->item_name."".$stock->type."' value='".$stock->item_name."'><label class='css-label' for='".$stock->item_name."".$stock->type."'>&nbsp;</label></td>
                          </tr>";
                    }
                  }

                }else {
                  if ($_SESSION['dept']=='pFloor') {
                    if ($_SESSION['gtntype']=='return_in') {
                      $sql="SELECT * FROM `finished_products` where status='active' group by Name;";
                      $rowSQL= mysqli_query( $con,$sql);
                      $iType='finished_product';
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['Name']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['Name']."".$iType."' name='txt".$row['Name']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input id='".$row['Name']."".$iType."' type='checkbox' class='css-checkbox' name='".$row['Name']."".$iType."' value='".$row['Name']."'><label class='css-label' for='".$row['Name']."".$iType."'>&nbsp;</label></td></tr>";
                      }
                    }elseif ($_SESSION['gtntype']=='in') {
                      $sql="SELECT * FROM `materials` where status='active' group by Name;";
                      $rowSQL= mysqli_query( $con,$sql);
                      $iType='material';
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['Name']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['Name']."".$iType."' name='txt".$row['Name']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input type='checkbox' id='".$row['Name']."".$iType."' class='css-checkbox' name='".$row['Name']."".$iType."' value='".$row['Name']."'><label class='css-label' for='".$row['Name']."".$iType."'>&nbsp;</label></td></tr>";
                      }
                    }
                  }
                  if ($_SESSION['dept']=='fGoods') {
                    $sql="SELECT * FROM `finished_products` where status='active' group by Name;";
                    $rowSQL= mysqli_query( $con,$sql);
                    $iType='finished_product';
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "<tr><td>".$row['Name']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['Name']."".$iType."' name='txt".$row['Name']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input id='".$row['Name']."".$iType."' type='checkbox' class='css-checkbox' name='".$row['Name']."".$iType."' value='".$row['Name']."'><label class='css-label' for='".$row['Name']."".$iType."'>&nbsp;</label></td></tr>";
                    }
                  }
                  if ($_SESSION['dept']=='store') {
                    $sql="SELECT * FROM `materials` where status='active' group by Name;";
                    $rowSQL= mysqli_query( $con,$sql);
                    $iType='material';
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "<tr><td>".$row['Name']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['Name']."".$iType."' name='txt".$row['Name']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input type='checkbox' id='".$row['Name']."".$iType."' class='css-checkbox' name='".$row['Name']."".$iType."' value='".$row['Name']."'><label class='css-label' for='".$row['Name']."".$iType."'>&nbsp;</label></td></tr>";
                    }
                  }
                }
                mysqli_close($con);
                ?>
              <tr><td class="bt">&nbsp;</td><td class="bt">&nbsp;</td><td class="bt">&nbsp;</td><td class="bt">&nbsp;</td><td class="bt chk"><input type="submit" name="btnNext" value="Next"></td></tr>
            </table>
          </form>
        </div>
      </div>
    </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
      <?php
      if(isset($_GET['count'])){
          if($_GET['count']==0){
              echo "<script type='text/javascript'>alert('Select A Item that have Have been/Needs to be Transfered');</script>";
          }
          unset($_GET['count']);
      }
      if(isset($_GET['count2'])){
          if($_GET['count2']==0){
              echo "<script type='text/javascript'>alert('Please add a Quantity for the Respective Item that was/Needs to be Transfered');</script>";
          }
          unset($_GET['count2']);
      }
      ?>
  </body>
</html>
<!--dan-->
