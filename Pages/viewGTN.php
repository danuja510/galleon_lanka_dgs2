<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['gtn'])){
   header('Location:manageGTN.php');
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
    <title>ViewGTN</title>
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
                <a href="manageGTN.php">
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
        <form action="../PHPScripts/viewGTNScript.php" method="post">
        <div class="row">
            <div class="col span-1-of-2">
                  <?php
                    $gtn=$_SESSION['gtn'];
                    $con = mysqli_connect("localhost","root","","galleon_lanka");
                    if(!$con)
                    {
                        die("Error while connecting to database");
                    }
                    $sql="SELECT * FROM `gtn` where `gtn_no`=".$gtn." GROUP BY `gtn_no`;";
                    $rowSQL= mysqli_query( $con,$sql);
                    $row = mysqli_fetch_array( $rowSQL );
                    echo "<div class='row'><div class='col span-1-of-2'>GTN No. </div><div class='col span-1-of-2'>".$row['gtn_no']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Department </div><div class='col span-1-of-2'>".$row['dept']."</div></div>";
                    $_SESSION['gdept']=$row['dept'];
                    echo "<div class='row'><div class='col span-1-of-2'>Type </div><div class='col span-1-of-2'>".$row['type']."</div></div>";
                    $_SESSION['gtype']=$row['type'];
                    echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['date']."</div></div>";
                    echo "<div class='row'><div class='col span-1-of-2'>Prepared by eno </div><div class='col span-1-of-2'>".$row['prepared_by']."</div></div>";

                    echo "<div class='row'><div class='col span-1-of-2'>Remark</div>";
                    echo "<div class='col span-1-of-2'><p>".$row['remarks']."</div></div>";
                    if($row['approved_by']!=null){
                      echo "<div class='row'><div class='col span-1-of-2'>Status :</div><div class='col span-1-of-2'>Approved</div></div>";
                    }else{
                      echo "<div class='row'><div class='col span-1-of-2'>Status :</div><div class='col span-1-of-2'>Pending</div></div>";

                    }
                  ?>
                </div>
            <div class="col span-1-of-2">
                <?php echo "<table><thead><th>Item ID</th><th>Item Type</th><th>Qty.</th></thead>";
                    $sql="SELECT * FROM `gtn` WHERE `gtn_no`=".$gtn.";";
                    $rowSQL= mysqli_query( $con,$sql);
                    mysqli_close($con);
                    while($row2=mysqli_fetch_assoc( $rowSQL )){
                        echo "<tr><td>".$row2['item_no']."</td><td>".$row2['item_type']."</td><td>".$row2['qty']."</td></tr>";
                    }
                    echo "</table>"; ?>
                </div>
        </div>
        <div class="row">
            <div class='row'>
                <div class='col span-1-of-2'>&nbsp;</div>
                <div class='col span-1-of-2'>
                <?php if($row['approved_by']!=null){
                  echo "<input type='submit' value='Print' name='btnPrint'>";
                }
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
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
      </footer>
</body>
</html>
<!--dan-->
