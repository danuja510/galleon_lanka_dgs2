<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='pFloor'){
    header('Location:empHome.php');
  }
  if(!isset($_SESSION['Inum'])){
    header('Location:createCashReceipt.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Cash Receipt</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <script type="text/javascript">

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
                <a href="createCashReceipt.php">
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
      $INO=$_SESSION['Inum'];
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT *,sum(total) as tot FROM `invoice` WHERE `invoice_no` = ".$INO." GROUP BY `invoice_no`,`cno`";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      echo "<h2> Invoice ".$row['invoice_no']." Details </h2>";
      $cid=$row['cno'];
      // mysqli_close($con);
    ?>
    <section class="section-manage">
      <div class="row">
        <div class="col span-2-of-2">
            <form action="../PHPScripts/createCashReceipt2Script.php" method="post">
              <table>
                <thead>
                  <th>Invoice No</th>
                  <th>Customer ID</th>
                  <th>Customer Name</th>
                  <th>Total</th>
                  <th class="bt">&nbsp;</th>
                </thead>
                <?php
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $sql1="SELECT * FROM `customer` WHERE `cno` = '".$cid."';";
                  $rowSQL1= mysqli_query( $con,$sql1);
                  $row1=mysqli_fetch_assoc( $rowSQL1 );
                    echo "
                    <tr>
                        <td>".$row['invoice_no']."</td>
                        <td>".$row1['cno']."</td>
                        <td>".$row1['Name']."</td>
                        <td><input type='number' id='".$row['invoice_no']."' name='".$row['invoice_no']."' value='".round($row['tot'],2)."' step='0.01' min='0'></td>
                        </tr>
                        ";
                  mysqli_close($con);
                ?>
                <tr>
                    <td class="bt">&nbsp;</td>
                    <td class="bt">&nbsp;</td>
                    <td class="bt">&nbsp;</td>
                    <td class="bt">
                        <input type="submit" name="btnConfirm" id="btnConfirm" value="Confirm">
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
  </body>
</html>
<!--sithara-->
