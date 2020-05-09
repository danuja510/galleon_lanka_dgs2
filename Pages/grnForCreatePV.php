<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
  else if (!isset($_SESSION['sid'])) {
    header('Location:CreatePaymentVoucher.php');
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
    <title>GRN</title>
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
        echo "<h2> GRNs of ".$row['Name']."</h2>";
        mysqli_close($con);
       ?>
       <section class="section-manage">
         <div class="row">
           <div class="col span-8-of-8">
             <form action="../PHPScripts/grnForCreatePVScript.php" method="post">
               <table>
                 <thead><th>GRN No.  </th><th>PO No. </th><th>Material ID</th><th>Quantity</th><th>Date</th><th>Amount</th><th>Remarks</th></thead>
                 <?php
                 $con = mysqli_connect("localhost","root","","galleon_lanka");
                 if(!$con)
                 {
                   die("Error while connecting to database");
                 }
                 $sql1="SELECT * FROM `grn` WHERE `sid` ='".$sid."';";
                 $rowSQL1= mysqli_query( $con,$sql1);
                 while($row1=mysqli_fetch_assoc( $rowSQL1 ))
                 {
                   echo"<tr><td>".$row1['grn_no']."</td><td>".$row1['po_no']."</td><td>".$row1['mid']."</td><td>".$row1['qty']."</td><td>".$row1['date']."</td><td>".$row1['amount']."</td><td>".$row1['remarks']."</td>
                   <td> <input id='".$row1['grn_no']."' type='checkbox'  name='".$row1['grn_no']."' value='".$row1['grn_no']."'></td>
                   </tr>";
                 }

                 $grnR=$row1['grn_no'];
                 mysqli_close($con);
                 ?>

                 <td class="bt"><input type="submit" name="btnNext" id="btnNext" value="Next"></td>

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
