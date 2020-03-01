<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['grn'])){
   header('Location:viewGRN.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View GRN</title>
  </head>
  <body>
    <form action="viewGRN2.php" method="post">
      <?php
        $grn=$_SESSION['grn'];
      	$con = mysqli_connect("localhost","root","","galleon_lanka");
      	if(!$con)
      	{
      		die("Error while connecting to database");
      	}
      	$sql="SELECT *,sum(amount) as value FROM `grn` where `grn_no`=".$grn." GROUP BY `grn_no`;";
      	$rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );
        echo "<h2>GRN No. ".$row['grn_no']."</h2>";
        echo "<h2>Supplier No. ".$row['sid']."</h2>";
        $sid=$row['sid'];
        echo "<h2>Purchase Order No. ".$row['po_no']."</h2>";
        echo "<h2>Date ".$row['date']."</h2>";
        echo "<h2>Prepared by eno ".$row['prepared_by_(eno)']."</h2>";
        echo "<h2>Amount Rs. ".$row['value']."</h2>";
        $value=$row['value'];
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
                Price
              </th>
            </thead>
            ";
            $sql="SELECT * FROM `grn` WHERE `grn_no`=".$grn.";";
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
          echo "<h2>Status :Approved</h2>";
        }else{
          echo "<h2>Status :Pending</h2>";
          echo "<input type='submit' value='approve' name='btnApprove'>";
        }

      ?>
    </form>
  </body>
  <?php
    if (isset($_POST['btnApprove'])) {
      // updating grn records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `grn` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `grn`.`grn_no` = ".$grn.";";
      mysqli_query( $con,$sql);
      // adding/updating creditor records
      $sql="SELECT * FROM `creditors` WHERE `sid` = ".$sid." ;";
  		$con = mysqli_connect("localhost","root","","galleon_lanka");
  			if(!$con)
  			{
  				die("Error while connecting to database");
  			}
  			$result= mysqli_query($con,$sql);
        $row = mysqli_fetch_array( $result );
  	if(mysqli_num_rows($result)>0){
      $value+=$row['amount'];
      $sql2="UPDATE `creditors` SET `amount` = '".$value."', `date` = CURDATE() WHERE `creditors`.`sid` = ".$sid.";";
      mysqli_query( $con,$sql2);

    }else{
      $sql2="INSERT INTO `creditors` (`sid`, `amount`, `date`) VALUES ('".$sid."', '".$value."',CURDATE() );";
      mysqli_query( $con,$sql2);
    }
      // adding/updating stock rocords
      $sql3="SELECT `mid`,`qty` FROM `grn` WHERE `grn_no`=".$grn."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        $sql="SELECT * FROM `stocks` WHERE `item_no` = ".$row3['mid']." AND `type`='material' AND `dept`='store' ;";
        $result= mysqli_query($con,$sql);
        $row = mysqli_fetch_array( $result );
    	  if(mysqli_num_rows($result)>0){
          $qty=$row3['qty']+$row['qty'];
          $sql2="UPDATE `stocks` SET `qty` = '".$qty."', `date` = CURDATE() WHERE `stocks`.`item_no` = ".$row3['mid']." AND `type`='material' AND `dept`='store';";
          mysqli_query( $con,$sql2);
        }else{
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['mid']."', '".$row3['qty']."', 'material', CURDATE(), 'store');";
          mysqli_query( $con,$sql2);
        }
      }
      mysqli_close($con);
    }

   ?>
</html>
<!--dan-->
