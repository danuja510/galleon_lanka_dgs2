<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 if(!isset($_SESSION['gtn'])){
   header('Location:manageGTN.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ViewGTN</title>
  </head>
  <body>
    <form action="viewGTN.php" method="post">
      <?php
        $gtn=$_SESSION['gtn'];
      	$con = mysqli_connect("localhost","root","","galleon_lanka");
      	if(!$con)
      	{
      		die("Error while connecting to database");
      	}
      	$sql="SELECT * FROM `gtn` where `gtn_no`=".$gtn." GROUP BY `gtn_no`;";
      	$rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );
        echo "<h2>GTN No. ".$row['gtn_no']."</h2>";
        echo "<h2>Department ".$row['dept']."</h2>";
        $dept=$row['dept'];
        echo "<h2>Type ".$row['type']."</h2>";
        $type=$row['type'];
        echo "<h2>Date ".$row['date']."</h2>";
        echo "<h2>Prepared by eno ".$row['prepared_by']."</h2>";
        echo "
          <table>
            <thead>
              <th>
                Item ID
              </th>
              <th>
                Item Type
              </th>
              <th>
                Qty.
              </th>
            </thead>
            ";
            $sql="SELECT * FROM `gtn` WHERE `gtn_no`=".$gtn.";";
            $rowSQL= mysqli_query( $con,$sql);
            mysqli_close($con);
            while($row2=mysqli_fetch_assoc( $rowSQL )){
              echo "
                <tr>
                  <td>
                    ".$row2['item_no']."
                  </td>
                  <td>
                    ".$row2['item_type']."
                  </td>
                  <td>
                    ".$row2['qty']."
                  </td>
                </tr>
              ";
            }
          echo "
          </table>
        ";
        echo "<h2>Remarks</h2>";
        echo "<p>".$row['remarks']."</p>";
        if($row['approved_by']!=null){
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
      // updating gtn records to approved
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="UPDATE `gtn` SET `approved_by` = '".$_SESSION['eno']."' WHERE `gtn`.`gtn_no` = ".$gtn.";";
      mysqli_query( $con,$sql);
        // adding/updating stock rocords
      $sql3="SELECT `item_no`,`qty`,`item_type` FROM `gtn` WHERE `gtn_no`=".$gtn."";
      $rowSQL3= mysqli_query( $con,$sql3);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
    	  if($type=='in'){
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".$row3['qty']."', '".$row3['item_type']."', CURDATE(), '".$dept."');";
        }elseif ($type=='out') {
          $sql2="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row3['item_no']."', '".-$row3['qty']."', '".$row3['item_type']."', CURDATE(), '".$dept."');";
        }
        mysqli_query( $con,$sql2);

      }
      mysqli_close($con);
    }

   ?>
</html>
<!--dan-->
