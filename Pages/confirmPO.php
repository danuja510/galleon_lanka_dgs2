<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['sid'])) {
    header('Location:createPurchaseOrders.php');
  }else if (!isset($_SESSION['PO'])) {
    header('Location:createPurchaseOrders.php');
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
    <title>ConfirmPurchaseOrder</title>
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
      <section class="conf-gtn">
      <div class="row">
          <div class="col span-2-of-2">
          </div>
            <table>
              <thead>
                <th>Material No.</th>
                <th>Material Name</th>
                <th>Material Type</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Amount</th>
              </thead>
              <?php
                $date=$_SESSION['date'];
                $query=[];
                $PO=$_SESSION['PO'];
                $POs=explode(',',$PO);
                $count=0;
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                    die("Error while connecting to database");
                }
                $rowSQL = mysqli_query( $con,"SELECT MAX( po_no ) AS max FROM `purchase_orders`;" );
                $row = mysqli_fetch_array( $rowSQL );
                $max = $row['max'];
                $po_no=$max+1;
                for ($i=0; $i <sizeof($POs)-1 ; $i++) {
                  $order=explode('x',$POs[$i]);
                  if ($order[1]==0) {
                  }else {
                    $count++;
                    $con = mysqli_connect("localhost","root","","galleon_lanka");
                    if(!$con)
                    {
                      die("Error while connecting to database");
                    }
                    $sql="SELECT * FROM `materials` WHERE `mid` = ".$order[0].";";
                    $rowSQL= mysqli_query( $con,$sql);
                    $row = mysqli_fetch_array( $rowSQL );
                    mysqli_close($con);
                    echo "<tr>
                        <td>".$order[0]."</td>
                        <td>".$row['Name']."</td>
                        <td>".$row['Type']."</td>
                        <td>".$row['value']."</td>
                        <td>".$order[1]."</td>
                        <td>".$row['value']*$order[1]."</td>
                      </tr>";
                    $query[$i]="INSERT INTO `purchase_orders` (`no`, `po_no`, `sid`, `mid`, `qty`, `prep_date`,
                     `amount`, `delivery_date`, `prepared_by_(eno)`, `approvedBy`) VALUES
                     (NULL, '".$po_no."', '".$_SESSION['sid']."', '".$order[0]."', '".$order[1]."', CURDATE(), '".$row['value']*$order[1]."',
                      '".$date."', '".$_SESSION['eno']."', NULL);";
                  }
                }
                $_SESSION['POQ']=$query;
                $_SESSION['POQC']=$count;
                unset($_SESSION['sid']);
                unset($_SESSION['PO']);
              ?>
              <form  action="../PHPScripts/confirmPOScript.php" method="post">
                <tr>
                  <td class='bt'>&nbsp;</td>
                  <td class='bt'>&nbsp;</td>
                  <td class='bt'>&nbsp;</td>
                  <td class='bt'>&nbsp;</td>
                  <td class='bt'>&nbsp;</td>
                  <td class="bt">
                    <input type="submit" name="btnConfirm" value="Confirm" id="btnConfirm">
                  </td>
                </tr>
              </form>
            </table>
          </div>
      </section>
      <footer>
        <div class="row"><p>Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>
<!--dan-->
