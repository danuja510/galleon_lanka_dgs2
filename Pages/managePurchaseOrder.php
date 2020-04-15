<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['pOrder'])){
   header('Location:viewPurchaseOrders.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage PO</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
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
      <form action="managePurchaseOrder.php" method="post">
      <div class="row">
          <div class="col span-1-of-2">
          <?php
            $PO=$_SESSION['pOrder'];
            $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
            {
              die("Error while connecting to database");
            }
            $sql="SELECT *,sum(amount) as price FROM `purchase_orders` where `po_no`=".$PO." GROUP BY `po_no`;";
            $rowSQL= mysqli_query( $con,$sql);
            $row = mysqli_fetch_array( $rowSQL );
            echo "<div class='row'><div class='col span-1-of-2'>Purchase order No.</div><div class='col span-1-of-2'> ".$row['po_no']."</div></div>";
            echo "<div class='row'><div class='col span-1-of-2'>Supplier No.</div><div class='col span-1-of-2'> ".$row['sid']."</div></div>";
            $sid=$row['sid'];
            echo "<div class='row'><div class='col span-1-of-2'>Date </div><div class='col span-1-of-2'>".$row['prep_date'] ."</div></div>";
            echo "<div class='row'><div class='col span-1-of-2'>Prepared by eno </div><div class='col span-1-of-2'> ".$row['prepared_by_(eno)']."</div></div>";
            echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'> ".$row['price']."</div></div>";
            if($row['approvedBy']!=null){
              echo"<div class='row'><div class='col span-1-of-2'>Status : </div><div class='col span-1-of-2'> Approved</div></div>";}
            else{
              echo"<div class='row'><div class='col span-1-of-2'>Status : </div><div class='col span-1-of-2'> Pending</div></div>";}
            $value=$row['amount'];
            
        echo "
            </div>
            <div class='col span-1-of-2'>
          <table>
            <thead>
              <th>
                Material ID
              </th>
              <th>
                Qty.
              </th>
              <th>
                value
              </th>
            </thead>
            ";
            $sql="SELECT * FROM `purchase_orders` WHERE `po_no`=".$PO.";";
            $rowSQL= mysqli_query( $con,$sql);
            mysqli_close($con);
            while($row2=mysqli_fetch_assoc( $rowSQL )){
              echo "
                <tr>
                  <td>
                    ".$row2['mid']."
                  </td>
                  <td>
                    ".$row2['qty']."
                  </td>
                  <td>
                    ".$row2['amount']."
                  </td>
                </tr>
              ";
            }
          echo "
              </table>
            </div>
          </div>
          
          <div class='row'>
          <div class='row'>
              <div class='col span-1-of-2'>&nbsp;</div>
              <div class='col span-1-of-2'>";
          if($row['approvedBy']!=null){
              echo"<input type='submit' value='Print' name='btnPrint'>";
          }else{
            echo"<input type='submit' value='approve' name='btnApprove'>";
          }
          echo"</div>
          </div>
      </div>";
      ?>
    </form>
      
     </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
    <?php
    if (isset($_POST['btnApprove'])) {
      // updating invoice records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `purchase_orders` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `purchase_orders`.`po_no` = ".$PO.";";
      mysqli_query( $con,$sql);
      // adding creditor records

        $sql2="INSERT INTO `creditors` (`no`,`sid`, `amount`, `date`) VALUES (NULL,'".$sid."', '".$value."',CURDATE());";
        mysqli_query( $con,$sql2);
      }
    if (isset($_POST['btnPrint'])) {
      header('Location:../Reports/printPurchaseOrder.php');
    }
    ?>
  </body>
</table>
<!--gima-->
