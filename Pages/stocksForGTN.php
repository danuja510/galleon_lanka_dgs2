<?php
 session_start();
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
              <thead><th>Item No.</th><th>Type</th><th>Available Qty.</th><th>Qty. to be transfered <?php echo $_SESSION['gtntype']; ?></th><th class="bt">&nbsp;</th>
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
                      $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' and `type` = 'finished_product' GROUP BY `item_no`,`type`;";
                      $rowSQL= mysqli_query( $con,$sql);
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['item_no']."</td><td>".$row['type']."</td><td>".$row['Qty']."</td><td><input type='number' id='txt".$row['item_no']."".$row['type']."' name='txt".$row['item_no']."".$row['type']."' step='1' min='0' max='".$row['Qty']."' value='0'></td><td class='chk'><input type='checkbox' id='".$row['item_no']."".$row['type']."' class='css-checkbox' name='".$row['item_no']."".$row['type']."' value='".$row['item_no']."'><label class='css-label' for='".$row['item_no']."".$row['type']."'>&nbsp;</label></td></tr>";
                      }
                    }elseif ($_SESSION['gtntype']=='return_out') {
                      $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' and `type` = 'material' GROUP BY `item_no`,`type`;";
                      $rowSQL= mysqli_query( $con,$sql);
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['item_no']."</td><td>".$row['type']."</td><td>".$row['Qty']."</td><td><input type='number' id='txt".$row['item_no']."".$row['type']."' name='txt".$row['item_no']."".$row['type']."' step='1' min='0' max='".$row['Qty']."' value='0'></td><td class='chk'><input type='checkbox' id='".$row['item_no']."".$row['type']."' class='css-checkbox' name='".$row['item_no']."".$row['type']."' value='".$row['item_no']."'><label class='css-label' for='".$row['item_no']."".$row['type']."'>&nbsp;</label></td></tr>";
                      }
                    }
                  }else {
                    $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='".$_SESSION['dept']."' GROUP BY `item_no`,`type`;";
                    $rowSQL= mysqli_query( $con,$sql);
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "<tr><td>".$row['item_no']."</td><td>".$row['type']."</td><td>".$row['Qty']."</td><td><input type='number' id='txt".$row['item_no']."".$row['type']."' name='txt".$row['item_no']."".$row['type']."' step='1' min='0' max='".$row['Qty']."' value='0'></td><td class='chk'><input type='checkbox' id='".$row['item_no']."".$row['type']."' class='css-checkbox' name='".$row['item_no']."".$row['type']."' value='".$row['item_no']."'><label class='css-label' for='".$row['item_no']."".$row['type']."'>&nbsp;</label></td></tr>";
                    }
                  }

                }else {
                  if ($_SESSION['dept']=='pFloor') {
                    if ($_SESSION['gtntype']=='return_in') {
                      $sql="SELECT * FROM `finished_products` where status='active';";
                      $rowSQL= mysqli_query( $con,$sql);
                      $iType='finished_product';
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['fp_id']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['fp_id']."".$iType."' name='txt".$row['fp_id']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input id='".$row['fp_id']."".$iType."' type='checkbox' class='css-checkbox' name='".$row['fp_id']."".$iType."' value='".$row['fp_id']."'><label class='css-label' for='".$row['fp_id']."".$iType."'>&nbsp;</label></td></tr>";
                      }
                    }elseif ($_SESSION['gtntype']=='in') {
                      $sql="SELECT * FROM `materials` where status='active';";
                      $rowSQL= mysqli_query( $con,$sql);
                      $iType='material';
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row['mid']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['mid']."".$iType."' name='txt".$row['mid']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input type='checkbox' id='".$row['mid']."".$iType."' class='css-checkbox' name='".$row['mid']."".$iType."' value='".$row['mid']."'><label class='css-label' for='".$row['mid']."".$iType."'>&nbsp;</label></td></tr>";
                      }
                    }
                  }
                  if ($_SESSION['dept']=='fGoods') {
                    $sql="SELECT * FROM `finished_products` where status='active';";
                    $rowSQL= mysqli_query( $con,$sql);
                    $iType='finished_product';
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "<tr><td>".$row['fp_id']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['fp_id']."".$iType."' name='txt".$row['fp_id']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input id='".$row['fp_id']."".$iType."' type='checkbox' class='css-checkbox' name='".$row['fp_id']."".$iType."' value='".$row['fp_id']."'><label class='css-label' for='".$row['fp_id']."".$iType."'>&nbsp;</label></td></tr>";
                    }
                  }
                  if ($_SESSION['dept']=='store') {
                    $sql="SELECT * FROM `materials` where status='active';";
                    $rowSQL= mysqli_query( $con,$sql);
                    $iType='material';
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "<tr><td>".$row['mid']."</td><td>".$iType."</td><td>-</td><td><input type='number' id='txt".$row['mid']."".$iType."' name='txt".$row['mid']."".$iType."' step='1' min='0' value='0'></td><td class='chk'><input type='checkbox' id='".$row['mid']."".$iType."' class='css-checkbox' name='".$row['mid']."".$iType."' value='".$row['mid']."'><label class='css-label' for='".$row['mid']."".$iType."'>&nbsp;</label></td></tr>";
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
