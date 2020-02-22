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
      	$sql="SELECT *,sum(amount) as value FROM `grn` where `grn_no`=1 GROUP BY `grn_no`;";
      	$rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );
        echo "<h2>GRN No. ".$row['grn_no']."</h2>";
        echo "<h2>Supplier No. ".$row['sid']."</h2>";
        echo "<h2>Purchase Order No. ".$row['po_no']."</h2>";
        echo "<h2>Date ".$row['date']."</h2>";
        echo "<h2>Prepared by eno ".$row['prepared_by_(eno)']."</h2>";
        echo "<h2>Amount Rs. ".$row['value']."</h2>";
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
            while($row=mysqli_fetch_assoc( $rowSQL )){
              echo "
                <tr>
                  <td>
                    ".$row['mid']."
                  </td>
                  <td>
                    ".$row['qty']."
                  </td>
                  <td>
                    ".$row['amount']."
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
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `grn` SET `approvedBy` = '".$_SESSION['eno']."' WHERE `grn`.`grn_no` = ".$grn.";";
      mysqli_query( $con,$sql);
    }
  ?>
</html>
