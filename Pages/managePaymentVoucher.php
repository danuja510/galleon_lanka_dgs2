<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
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
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="viewPaymentVoucher.php">
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
                  echo "<div class='row'><div class='col span-1-of-2'><span>PV No.</span> </div><div class='col span-1-of-2'>".$row['pv_no']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'><span>GRN No.</span> </div><div class='col span-1-of-2'>".$row['grn_no']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'><span>Supplier</span> </div><div class='col span-1-of-2'>".$row['sid']."</div></div>";
                    $_SESSION['PVSID']=$row['sid'];
                  echo "<div class='row'><div class='col span-1-of-2'><span>Date </span></div><div class='col span-1-of-2'>".$row['date']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'><span>Amount Rs.</span> </div><div class='col span-1-of-2'>".$row['amount']."</div></div>";
                    $_SESSION['PVAmount']=$row['amount'];
                  echo "<div class='row'><div class='col span-1-of-2'><span>Prepared By</span> </div><div class='col span-1-of-2'>".$row['prepared_by_(eno)']."</div></div>";
                  echo "<div class='row'><div class='col span-1-of-2'><span>Remarks</span> </div><div class='col span-1-of-2'>".$row['remarks']."</div></div>";

                  if($row['approvedBy']!=null)
                  {
                    echo "<div class='row'><div class='col span-1-of-2'><span>Status</span> </div><div class='col span-1-of-2'>Approved</div></div>";
                  }
                  else
                  {
                    echo "<div class='row'><div class='col span-1-of-2'><span>Status</span> </div><div class='col span-1-of-2'>Pending</div></div>";
                  }
              ?>
                <div class='row'>
                    <div class='col span-1-of-2'>
                    </div>
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
        </form>
        </section>
        <footer>
          <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
          <div class="row"><p>Designed and Developed by DGS2</p></div>
        </footer>
    </body>
</html>
