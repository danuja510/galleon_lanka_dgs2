<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['INVOICE']) || !isset($_SESSION['cno'])) {
    header('Location:createInvoice.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>confirmInvoice</title>
  </head>
  <body>
      <table>
        <thead>
          <th>
            Product No.
          </th>
          <th>
            Product Name
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
              echo "
                <tr>
                  <td>
                    ".$order[0]."
                  </td>
                  <td>
                    ".$row['Name']."
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
              $query[$i]="INSERT INTO `invoice` (`no`, `invoice_no`, `cno`, `item_no`, `remarks`, `qty`, `value`, `prepared_by`,
                 `approved_by`, `date`, `po_no`, `vehicle_no`, `total`) VALUES
                 (NULL, '".$invoice_no."', '".$_SESSION['cno']."', '".$order[0]."', NULL, '".$order[1]."','".$row['value']."' ,'".$_SESSION['eno']."' ,
                    NULL, CURDATE(), NULL, NULL, '".$row['value']*$order[1]."')";
            }
          }
        ?>
        <form  action="confirmInvoice.php" method="post">
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
