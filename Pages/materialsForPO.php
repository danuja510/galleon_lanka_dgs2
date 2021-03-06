<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }else if (!isset($_SESSION['sid'])) {
    header('Location:createPurchaseOrders.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PurchaseOrder</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <script type="text/javascript">
      function validateDate(){
        var d=document.getElementById('txtDate').value;
        if (new Date()> new Date(Date.parse(d))) {
          alert("select a valid delivery date");
          event.preventDefault();
        }else {
        }
      }
    </script>
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
                <a href="createPurchaseOrders.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <?php
      $sid=$_SESSION['sid'];
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      echo "<h2> Materials from ".$row['Name']."</h2>";
      mysqli_close($con);
    ?>
    <section class="section-manage">
      <div class="row">
        <div class="col span-2-of-2">
            <form action="../PHPScripts/materialsForPOScript.php" method="post">
              <table>
                <thead><th>Name</th><th>Type</th><th>Value</th><th>Qty.</th><th class="bt">&nbsp;</th></thead>
                <?php
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $sql1="SELECT * FROM `materials` WHERE `sid` = '".$sid."' and status='active';";
                  $rowSQL1= mysqli_query( $con,$sql1);
                  while($row1=mysqli_fetch_assoc( $rowSQL1 )){
                    echo "
                    <tr>
                        <td>".$row1['Name']."</td>
                        <td>".$row1['Type']."</td>
                        <td>".$row1['value']."</td>
                        <td><input type='number' id='txt".$row1['mid']."' name='txt".$row1['mid']."' value='0' step='1' min='0'></td>
                        <td class='chk'><input id='".$row1['mid']."' type='checkbox' class='css-checkbox' name='".$row1['mid']."' value='".$row1['mid']."'><label class='css-label' for='".$row1['mid']."'>&nbsp;</label></td>
                        </tr>
                        ";
                  }
                  mysqli_close($con);
                ?>
                <tr>
                  <td>
                    <label class="dd" for="txtDate">Delivery Date</label>
                  </td>
                  <td>
                    <input type="date" name="txtDate" id="txtDate" required>
                  </td>
                    <td class="bt">&nbsp;</td>
                    <td class="bt">&nbsp;</td>
                    <td class="bt">
                        <input type="submit" name="btnNext" id="btnNext" value="Next" onclick="validateDate()">
                    </td>
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
              echo "<script type='text/javascript'>alert('Select A Material to Order');</script>";
          }
          unset($_GET['count']);
      }
      if(isset($_GET['count2'])){
          if($_GET['count2']==0){
              echo "<script type='text/javascript'>alert('Please add a Quantity for the Respective Material to Order');</script>";
          }
          unset($_GET['count2']);
      }
      ?>
  </body>
</html>
<!--dan-->
