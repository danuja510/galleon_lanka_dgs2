<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['dept'])) {
    header('Location:empHome.php');
  }else if (!isset($_SESSION['GTN'])) {
    header('Location:stocksForGTN.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ConfirmGTN</title>
  </head>
  <body>
    <table>
      <thead>
        <th>
          Item No.
        </th>
        <th>
          Item Type
        </th>
        <th>
          Qty.
        </th>
      </thead>
      <?php
        $query=[];
        $GTN=$_SESSION['GTN'];
        $GTN1=explode('+',$GTN);
        $gtnType=$GTN1[0];
        $GTNs=explode(',',$GTN1[1]);
        $count=0;
        $con = mysqli_connect("localhost","root","","galleon_lanka");
    		if(!$con)
    		{
    			die("Error while connecting to database");
    		}
    		$rowSQL = mysqli_query( $con,"SELECT MAX( gtn_no ) AS max FROM `gtn`;" );
    		$row = mysqli_fetch_array( $rowSQL );
    		$max = $row['max'];
    		$gtn_no=$max+1;
        for ($i=0; $i <sizeof($GTNs)-1 ; $i++) {
          //echo "$POs[$i]";
          $order=explode('x',$GTNs[$i]);
          if ($order[1]==0) {
          }else {
          //  echo $order[0].'x'.$order[1].'X'.$order[2];
            $count++;
            $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
            {
              die("Error while connecting to database");
            }
            //$sql="SELECT * FROM `stocks` WHERE `item_no` = ".$order[0]." AND `type`='".$order[2]."';";
            //$rowSQL= mysqli_query( $con,$sql);
            //$row = mysqli_fetch_array( $rowSQL );
            mysqli_close($con);
            echo "
              <tr>
                <td>
                  ".$order[0]."
                </td>
                <td>
                  ".$order[2]."
                </td>
                <td>
                  ".$order[1]."
                </td>
              </tr>
            ";
            $query[$i]="INSERT INTO `gtn` (`no`, `gtn_no`, `item_no`,`item_type`, `qty`, `type`, `remarks`, `dept`,
               `prepared_by`, `approved_by`, `date`) VALUES (NULL, '".$gtn_no."', '".$order[0]."', '".$order[2]."', '".$order[1]."','".$gtnType."', NULL, '".$_SESSION['dept']."',
                  '".$_SESSION['eno']."', NULL, CURDATE());";
          }
        }
      ?>
      <form  action="confirmGTN.php" method="post">
        <tr>
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
