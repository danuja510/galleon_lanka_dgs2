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
    <title>view Purchase orders</title>
  </head>
  <body>
    <form action="viewPurchaseOrders.php" method="post">
      <table>
        <thead>
          <th>Purchase order no.</th>
          <th>Supplier</th>
          <th>Date</th>
          <th>Prepared By(eno)</th>
          <th>Status</th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `purchase_orders` GROUP BY `po_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          mysqli_close($con);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            if($row['approvedBy']!=null){
              $approve='approved';
            }else{
              $approve='pending';
            }
            echo "
              <tr>
                <td>
                ".$row['po_no']."
                </td>
                <td>
                ".$row['sid']."
                </td>
                <td>
                ".$row['prep_date']."
                </td>
                <td>
                  ".$row['prepared_by_(eno)']."
                </td>
                <td>
                  ".$approve."
                </td>
                <td>
                  <input type='submit' name='".$row['po_no']."' value='manage'>
                </td>
              </tr>
            ";
          }
        ?>
      </table>
    </form>
    <?php
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `purchase_orders` GROUP BY `po_no`;";
      $rowSQL= mysqli_query( $con,$sql);
      mysqli_close($con);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        if(isset($_POST[$row['po_no']])){
          $_SESSION['purchaseOrder']=$row['po_no'];
          header('Location:managePurchaseOrder.php');
        }
      }
    ?>
  </body>
</html>
