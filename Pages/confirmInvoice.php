<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='Manager' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }else if (!isset($_SESSION['INVOICE']) || !isset($_SESSION['cno'])) {
    header('Location:createInvoice.php');
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
    <title>confirmInvoice</title>
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
                <a href="#">
                    <div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div>
                </a>
            </div>
        </div>
    </header>
    <section>
      <div class="row">
          <div class="col span-2-of-2">
              <table>
          <thead><th>Product No.</th><th>Product Name</th><th>Unit Price</th><th>Qty.</th><th>Amount</th></thead>
        <?php
          $query=[];
          $invoice=$_SESSION['INVOICE'];
          $invoices=explode(',',$invoice);
          $count=0;
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $rowSQL = mysqli_query( $con,"SELECT MAX( invoice_no ) AS max FROM `invoice`;" );
          $row = mysqli_fetch_array( $rowSQL );
          $max = $row['max'];
          $invoice_no=$max+1;
          for ($i=0; $i <sizeof($invoices)-1 ; $i++) {
            $order=explode('x',$invoices[$i]);
            if ($order[1]==0) {
            }else {
              $count++;
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `finished_products` WHERE `fp_id` = ".$order[0].";";
              $rowSQL= mysqli_query( $con,$sql);
              $row = mysqli_fetch_array( $rowSQL );
              mysqli_close($con);
              echo "<tr><td>".$order[0]."</td><td>".$row['Name']."</td><td>".$row['value']."</td><td>".$order[1]."</td><td>".$row['value']*$order[1]."</td></tr>";
              $query[$i]="INSERT INTO `invoice` (`no`, `invoice_no`, `cno`, `item_no`, `remarks`, `qty`, `value`, `prepared_by`,`approved_by`, `date`, `po_no`, `vehicle_no`, `total`) VALUES(NULL, '".$invoice_no."', '".$_SESSION['cno']."', '".$order[0]."', NULL, '".$order[1]."','".$row['value']."' ,'".$_SESSION['eno']."' ,NULL, CURDATE(), NULL, NULL, '".$row['value']*$order[1]."')";
            }
          }
            $_SESSION['InvoiceQ']=$query;
            $_SESSION['InvoiceQC']=$count;
            unset($_SESSION['cno']);
            unset($_SESSION['INVOICE']);
        ?>
        <form  action="../PHPScripts/confirmInvoiceScript.php" method="post">
          <tr>
            <td class="bt">&nbsp;</td>
            <td class="bt">&nbsp;</td>
            <td class="bt">&nbsp;</td>
            <td class="bt">&nbsp;</td>
            <td class="bt">&nbsp;</td>
            <td class="bt">
              <input type="submit" name="btnConfirm" value="Confirm" id="btnConfirm">
            </td>
          </tr>
        </form>
      </table>
          </div>
        </div>
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
