<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='fGoods'){
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
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>InputFinishedGoods</title>
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
            <div class="col span-2-of-2">
                <form action="../PHPScripts/InputFinishedGoodsScript.php" method="post">
                  <table>
                    <thead>
                      <th>Finished Product Name</th>
                      <th>Qty. to be Inserted</th>
                      <th class="bt">&nbsp;</th>
                    </thead>
                    <?php
                      $con = mysqli_connect("localhost","root","","galleon_lanka");
                      if(!$con)
                      {
                        die("Error while connecting to database");
                      }
                      $sql="SELECT * FROM `finished_products` where status = 'active';";
                      $rowSQL= mysqli_query( $con,$sql);
                      mysqli_close($con);
                      while($row=mysqli_fetch_assoc( $rowSQL )){
                        echo "
                          <tr>
                            <td>".$row['Name']."</td>
                            <td><input type='number' id='txt".$row['fp_id']."' name='txt".$row['fp_id']."' step='1' min='0' value='0'></td>
                            <td class='chk'><input class='css-checkbox' id='".$row['fp_id']."' type='checkbox' name='".$row['fp_id']."' value='".$row['fp_id']."' ><label class='css-label' for='".$row['fp_id']."'>&nbsp;</label></td>
                          </tr>
                        ";
                      }
                    ?>
                      <tr>
                        <td class="bt">&nbsp;</td>
                        <td class="bt">&nbsp;</td>
                        <td class="bt">&nbsp;</td>
                        <td class="bt"><input type="submit" name="btnNext" id="btnNext" value="Next"></td>
                      </tr>
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
              echo "<script type='text/javascript'>alert('Select A Finished product to input');</script>";
          }
          unset($_GET['count']);
      }
      if(isset($_GET['count2'])){
          if($_GET['count2']==0){
              echo "<script type='text/javascript'>alert('Please add a Quantity for the Respective Finished product');</script>";
          }
          unset($_GET['count2']);
      }
      ?>
  </body>
</html>
<!--dan-->
