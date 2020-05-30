<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='pFloor'){
    header('Location:empHome.php');
  }
 if(!isset($_SESSION['invoice'])){
   header('Location:manageInvoices.php');
 }

 if (isset($_GET['nes'])) {
   $nes=explode(',',$_GET['nes']);
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
    <title>ViewInvoice</title>
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
                <a href="manageInvoices.php">
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
    <form action="../PHPScripts/viewInvoiceScript.php" method="post">
        <div class="row">
            <div class="col span-1-of-2">
      <?php
        $invoice=$_SESSION['invoice'];
      	$con = mysqli_connect("localhost","root","","galleon_lanka");
      	if(!$con)
      	{
      		die("Error while connecting to database");
      	}
      	$sql="SELECT *,sum(total) as price FROM `invoice` where `invoice_no`=".$invoice." GROUP BY `invoice_no`;";
      	$rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );
        echo "<div class='row'><div class='col span-1-of-2'>Invoice No. </div><div class='col span-1-of-2'>".$row['invoice_no']."</div></div>";
        echo "<div class='row'><div class='col span-1-of-2'>Customer No. </div><div class='col span-1-of-2'>".$row['cno']."</div></div>";
        $_SESSION['Icno']=$row['cno'];
        echo "<div class='row'><div class='col span-1-of-2'>Purchase Order No. </div><div class='col span-1-of-2'>".$row['po_no']."</div></div>";
        echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['date']."</div></div>";
        echo "<div class='row'><div class='col span-1-of-2'>Prepared by eno </div><div class='col span-1-of-2'>".$row['prepared_by']."</div></div>";
        echo "<div class='row'><div class='col span-1-of-2'>Remarks </div><div class='col span-1-of-2'>".$row['remarks']."</div></div>";
        echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'>".$row['price']."</div></div>";
        $_SESSION['Ivalue']=$row['price'];
        if($row['approved_by']!=null){
            echo "<div class='row'><div class='col span-1-of-2'>Status :</div><div class='col span-1-of-2'>Approved</div></div>";
        }else{
          echo "<div class='row'><div class='col span-1-of-2'>Status :</div><div class='col span-1-of-2'>Pending</div></div>";
        }
        if (isset($_GET['nes'])) {
          echo "<div class='row'><div class='col span-2-of-2'><p class='nes2'><strong>Can't Be Approved! Not Enough Stocks</strong></p></div></div>";
        }
        ?>
        </div>
        <div class="col span-1-of-2">
        <?php
        $nesc= "";
        echo "<table><thead><th>Product ID</th><th>Qty.</th><th>value</th></thead>";
            $sql="SELECT * FROM `invoice` WHERE `invoice_no`=".$invoice.";";
            $rowSQL= mysqli_query( $con,$sql);
            mysqli_close($con);
            while($row2=mysqli_fetch_assoc( $rowSQL )){
              if (isset($_GET['nes'])) {
                for ($i=0; $i < sizeof($nes)-1; $i++) {
                  $nes2=explode('-', $nes[$i]);
                  $nesc= "";
                  if ($nes2[0]==$row2['item_no']) {
                    $nesc=" class='nes'";
                    break;
                  }
                }
              }
              echo "<tr><td".$nesc.">".$row2['item_no']."</td><td".$nesc.">".$row2['qty']."</td><td".$nesc.">".$row2['value']."</td></tr>";
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
                      if($row['approved_by']!=null){
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
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
<!--dan-->
