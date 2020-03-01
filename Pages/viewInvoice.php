<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['invoice'])){
   header('Location:manageInvoices.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View GRN</title>
  </head>
  <body>
    <form action="viewInvoice.php" method="post">
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
        echo "<h2>Invoice No. ".$row['invoice_no']."</h2>";
        echo "<h2>Customer No. ".$row['cno']."</h2>";
        $cno=$row['cno'];
        echo "<h2>Purchase Order No. ".$row['po_no']."</h2>";
        echo "<h2>Date ".$row['date']."</h2>";
        echo "<h2>Prepared by eno ".$row['prepared_by']."</h2>";
        echo "<h2>Amount Rs. ".$row['price']."</h2>";
        $value=$row['price'];
        echo "
          <table>
            <thead>
              <th>
                Product ID
              </th>
              <th>
                Qty.
              </th>
              <th>
                value
              </th>
            </thead>
            ";
            $sql="SELECT * FROM `invoice` WHERE `invoice_no`=".$invoice.";";
            $rowSQL= mysqli_query( $con,$sql);
            mysqli_close($con);
            while($row2=mysqli_fetch_assoc( $rowSQL )){
              echo "
                <tr>
                  <td>
                    ".$row2['item_no']."
                  </td>
                  <td>
                    ".$row2['qty']."
                  </td>
                  <td>
                    ".$row2['value']."
                  </td>
                </tr>
              ";
            }
          echo "
          </table>
        ";
        if($row['approved_by']!=null){
          echo "<h2>Status :Approved</h2>";
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
      $sql="UPDATE `invoice` SET `approved_by` = '".$_SESSION['eno']."' WHERE `invoice`.`invoice_no` = ".$invoice.";";
      mysqli_query( $con,$sql);
      // adding/updating debtor records
      $sql="SELECT * FROM `debtors` WHERE `cno` = ".$cno." ;";
  		$con = mysqli_connect("localhost","root","","galleon_lanka");
  		if(!$con)
  		{
  			die("Error while connecting to database");
  		}
  		$result= mysqli_query($con,$sql);
      $row = mysqli_fetch_array( $result );
    	if(mysqli_num_rows($result)>0){
        $value+=$row['amount'];
        $sql2="UPDATE `debtors` SET `amount` = '".$value."', `date` = CURDATE() WHERE `debtors`.`cno` = ".$cno.";";
        mysqli_query( $con,$sql2);
      }else{
        $sql2="INSERT INTO `debtors` (`cno`, `amount`, `date`) VALUES ('".$cno."', '".$value."',CURDATE() );";
        mysqli_query( $con,$sql2);
      }
      // updating stock rocords
      $sql3="SELECT `item_no`,`qty` FROM `invoice` WHERE `invoice_no`=".$invoice."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        $sql="SELECT * FROM `stocks` WHERE `item_no` = ".$row3['item_no']." AND `type`='finished product' AND `dept`='fGoods' ;";
        $result= mysqli_query($con,$sql);
        $row = mysqli_fetch_array( $result );
        $qty=$row['qty']-$row3['qty'];
        $sql2="UPDATE `stocks` SET `qty` = '".$qty."', `date` = CURDATE() WHERE `stocks`.`item_no` = ".$row3['item_no']." AND `type`='finished product' AND `dept`='fGoods';";
        mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
    }
    ?>
  </body>
</table>
<!--dan-->
