<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
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
            <div class="btn-navi">
              <i class="ion-navicon-round"></i>
            </div>
            <a href="empHome.php">
              <div class="btn-home">
                <i class="ion-home"></i>
                <p>Home</p>
              </div>
            </a>
              <a href="logout.php">
                <div class="btn-logout">
                  <i class="ion-log-out"></i>
                  <p>Logout</p>
                </div>
              </a>
              <a href="#">
                <div class="btn-account">
                    <i class="ion-ios-person"></i>
                    <p>Account</p>
                </div>
              </a>
          </div>
        </div>
    </header>
    <section class="section-view">
        <form action="viewGRN2.php" method="post">
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
                    $sid=$row['sid'];
                    echo "<div class='row'><div class='col span-1-of-2'>Purchase Order No. </div><div class='col span-1-of-2'>".$row['po_no']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['date']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Prepared by eno </div><div class='col span-1-of-2'>".$row['prepared_by_(eno)']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'>".$row['value']."</div></div>";
                    $value=$row['value'];
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
                        if($row['approvedBy']!=null){}
                        else{
                            echo "<input type='submit' value='Approve' name='btnConfirm' id='btnConfirm'>";
                        }
                    ?>
                    <input type='submit' value='Delete' name='btnDelete' id='btnDelete'>
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
  <?php
    if (isset($_POST['btnConfirm'])) {
      // updating grn records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `grn` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `grn`.`grn_no` = ".$grn.";";
      mysqli_query( $con,$sql);
      // adding/updating creditor records
      $sql2="INSERT INTO `creditors` (`sid`, `amount`, `date`) VALUES ('".$sid."', '".$value."',CURDATE() );";
      mysqli_query( $con,$sql2);
      // adding/updating stock rocords
      $sql3="SELECT `mid`,`qty` FROM `grn` WHERE `grn_no`=".$grn."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['mid']."', '".$row3['qty']."', 'material', CURDATE(), 'store');";
          mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
      header('Location:viewGRN.php');
    }
   ?>
</html>
<!--dan-->
