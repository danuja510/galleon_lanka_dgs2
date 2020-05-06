<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
  if(!isset($_SESSION['PV'])){
    header('Location:viewPaymentVoucher.php');
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
    <title>ManagePaymentVoucher</title>
  </head>
  <body>
      <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <div class="btn-navi"><i class="ion-navicon-round"></i></div>
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="#"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class="section-view">
      <div class="row">
       <div class="col span-1-of-2">
        <form action="../PHPScripts/managePVScript.php" method="post">
              <?php
              $PV=$_SESSION['PV'];
              $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                      die("Error while connecting to database");
                  }
                  $sql="SELECT * FROM `payment_voucher` where `pv_no`=".$PV." GROUP BY `pv_no`;";
                  $rowSQL= mysqli_query( $con,$sql);
                  $row = mysqli_fetch_array( $rowSQL );
                  echo "<div class='row'><div class='col span-1-of-2'>PV No. </div><div class='col span-1-of-2'>".$row['pv_no']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>GRN No. </div><div class='col span-1-of-2'>".$row['grn_no']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>Supplier </div><div class='col span-1-of-2'>".$row['sid']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['date']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'>".$row['amount']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>Prepared By </div><div class='col span-1-of-2'>".$row['prepared_by_(eno)']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'>Remarks </div><div class='col span-1-of-2'>".$row['remarks']."</div></div>";

                  if($row['approvedBy']!=null)
                  {
                    echo "<div class='row'><div class='col span-1-of-2'>Status </div><div class='col span-1-of-2'>Approved</div></div>";
                  }
                  else
                  {
                    echo "<div class='row'><div class='col span-1-of-2'>Status </div><div class='col span-1-of-2'>Pending</div></div>";
                  }
              ?>

              <div class='col span-1-of-2'>&nbsp;</div>
                <div class='col span-2-of-2'>
                  <?php
                  if($row['approvedBy']!=null)
                  {
                    echo "<input type='submit' value='Print' name='btnPrint'>";
                  }
                  else
                  {
                    echo "<input type='submit' value='Approve' name='btnConfirm' id='btnConfirm'>";
                  }
                  ?>
                </div>
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
