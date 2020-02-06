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
    <title>ConfirmPurchaseOrder</title>
  </head>
  <body>
    <table>
      <thead>
        <th>
          Material No.
        </th>
        <th>
          Material Name
        </th>
        <th>
          Material Type
        </th>
        <th>
          Unit Price
        </th>
        <th>
          Qty.
        </th>
        <th>
          Amount
        </th>
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
          //echo "$POs[$i]";
          $order=explode('x',$POs[$i]);
          if ($order[1]==0) {
          }else {
            //echo $order[0].'x'.$order[1];
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
            echo "
              <tr>
                <td>
                  ".$order[0]."
                </td>
                <td>
                  ".$row['Name']."
                </td>
                <td>
                  ".$row['Type']."
                </td>
                <td>
                  ".$row['value']."
                </td>
                <td>
                  ".$order[1]."
                </td>
                <td>
                  ".$row['value']*$order[1]."
                </td>
              </tr>
            ";
            $query[$i]="INSERT INTO `purchase_orders` (`no`, `po_no`, `sid`, `mid`, `qty`, `prep_date`,
             `amount`, `delivery_date`, `prepared_by_(eno)`, `approvedBy`) VALUES
             (NULL, '".$po_no."', '".$_SESSION['sid']."', '".$order[0]."', '".$order[1]."', CURDATE(), '".$row['value']*$order[1]."',
              '".$date."', '".$_SESSION['eno']."', NULL);";
          }
        }
      ?>
      <form  action="confirmPO.php" method="post">
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <input type="submit" name="btnConfirm" value="Confirm" id="btnConfirm">
          </td>
        </tr>
      </form>
    </table>
    <?php
      if (isset($_POST['btnConfirm'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i < $count; $i++) {
          mysqli_query($con,$query[$i]);
        }
        mysqli_close($con);
      }
   ?>
  </body>
</html>
<!--dan-->
