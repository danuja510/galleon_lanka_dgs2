<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
 if(!isset($_SESSION['grn'])){
   header('Location:viewGRN.php');
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
    <title>View GRN</title>
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
                <a href="viewGRN.php">
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
        <form action="../PHPScripts/viewGRN2Script.php" method="post">
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    $grn=$_SESSION['grn'];
                    $con = mysqli_connect("localhost","root","","galleon_lanka");
                    if(!$con)
                    {
                        die("Error while connecting to database");
                    }
                    $sql="SELECT *,sum(amount) as value FROM `grn` where `grn_no`=".$grn." GROUP BY `grn_no`;";
                    $rowSQL= mysqli_query( $con,$sql);
                    $row = mysqli_fetch_array( $rowSQL );
                    echo "<div class='row'><div class='col span-1-of-2'>GRN No. </div><div class='col span-1-of-2'>".$row['grn_no']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Supplier No. </div><div class='col span-1-of-2'>".$row['sid']."</div></div>";
                    $_SESSION['gsid']=$row['sid'];
                    echo "<div class='row'><div class='col span-1-of-2'>Purchase Order No. </div><div class='col span-1-of-2'>".$row['po_no']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['date']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Prepared by eno </div><div class='col span-1-of-2'>".$row['prepared_by_(eno)']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'>".$row['value']."</div></div>";
                    $_SESSION['value']=$row['value'];
                    if($row['approvedBy']!=null){
                        echo "<div class='row'><div class='col span-1-of-2'>Status </div><div class='col span-1-of-2'>Approved</div></div>";
                    }else{
                        echo "<div class='row'><div class='col span-1-of-2'>Status </div><div class='col span-1-of-2'>Pending</div></div>";
                    }
                ?>
            </div>
            <div class="col span-1-of-2">
                <?php
                    echo "<table><thead><th>Material ID</th><th>Qty.</th><th>Price</th></thead>";
                    $sql="SELECT * FROM `grn` WHERE `grn_no`=".$grn.";";
                    $rowSQL= mysqli_query( $con,$sql);
                    mysqli_close($con);
                    while($row2=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row2['mid']."</td><td>".$row2['qty']."</td><td>".$row2['amount']."</td></tr>";
                    }
                    echo "</table>";
                ?>
            </div>
        </div>
        <div class="row">
            <div class='row'>
                <div class='col span-1-of-2'>&nbsp;</div>
                <div class='col span-1-of-2'>
                    <?php
                        if($row['approvedBy']!=null){
                          echo "<input type='submit' value='Print' name='btnPrint'>";
                          if ($_SESSION['DES']=='Manager') {
                            echo "<input type='submit' value='Delete' name='btnDelete2' id='btnDelete2'>";
                          }
                        }
                        else{
                          if ($_SESSION['DES']=='Manager') {
                            echo "<input type='submit' value='Approve' name='btnConfirm' id='btnConfirm'>";
                          }
                          echo "<input type='submit' value='Delete' name='btnDelete' id='btnDelete'>";
                        }
                    ?>
                </div>
            </div>
        </div>
      </form>
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
