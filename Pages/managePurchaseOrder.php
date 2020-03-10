<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['purchaseOrder'])){
   header('Location:viewPurchaseOrders.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage PO</title>
  </head>
  <body>
    <form action="managePurchaseOrder.php" method="post">
      <?php
        $PO=$_SESSION['purchaseOrder'];
      	$con = mysqli_connect("localhost","root","","galleon_lanka");
      	if(!$con)
      	{
      		die("Error while connecting to database");
      	}
      	$sql="SELECT *,sum(amount) as price FROM `purchase_orders` where `po_no`=".$PO." GROUP BY `po_no`;";
      	$rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );
        echo "<h2>Purchase order No. ".$row['po_no']."</h2>";
        echo "<h2>Supplier No. ".$row['sid']."</h2>";
        $sid=$row['sid'];
        echo "<h2>Date ".$row['prep_date']."</h2>";
        echo "<h2>Prepared by eno ".$row['prepared_by_(eno)']."</h2>";
        echo "<h2>Amount Rs. ".$row['price']."</h2>";
        $value=$row['amount'];
        echo "
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
        ";
        if($row['approvedBy']!=null){
          echo "<h2>Status :Approved</h2>
            <input type='submit' value='Print' name='btnPrint'>
          ";
        }else{
          echo "<h2>Status :Pending</h2>";
          echo "<input type='submit' value='approve' name='btnApprove'>";
        }

      ?>
    </form>
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
      header('Location:printPurchaseOrder.php');
    }
    ?>
  </body>
</table>
<!--gima-->
