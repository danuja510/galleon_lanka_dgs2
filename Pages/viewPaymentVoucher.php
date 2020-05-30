<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
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
    <title>ViewPaymentVoucher</title>
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
      <div class="col span-1-of-10">
        <a href="createPaymentVoucher.php">
          <div class="new">
            <i class="ion-ios-compose-outline"></i>
            New Payment Voucher
          </div>
        </a>
      </div>
      <div class="col span-9-of-10">
        <form action="../PHPScripts/viewPaymentVoucherScript.php" method="post">
        <table>
          <thead><th>Payment Voucher No.</th><th>GRN no.</th><th>Supplier ID</th><th>Date</th><th>Amount</th><th>Prepared By</th><th>Remarks</th><th>Status</th><th class="bt">&nbsp;</th> </thead>

      <?php

      	$con = mysqli_connect("localhost","root","","galleon_lanka");
      	if(!$con)
      	{
      		die("Error while connecting to database");
      	}
      	$sql="SELECT * FROM `payment_voucher` ;";
      	$rowSQL= mysqli_query( $con,$sql);
      	mysqli_close($con);

        while($row=mysqli_fetch_assoc( $rowSQL))
        {
        if($row['approvedBy']!=null)
            {
            $approve="Approved";
            }
            else
            {
            $approve="Pending";
            }

            echo "<tr><td>".$row['pv_no']."</td><td>".$row['grn_no']."</td><td>".$row['sid']."</td><td>".$row['date']."</td><td>".$row['amount']."</td><td>".$row['prepared_by_(eno)']."</td><td>".$row['remarks']."</td><td>".$approve."</td>";

            echo "<td>" ."<input type='submit' value='View' id='btnView".$row['pv_no'] ."' name='btnView".$row['pv_no'] ."' > "."</td></tr>";
        }


        ?>
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
<!--jini-->
