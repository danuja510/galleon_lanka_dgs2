<?php
session_start();
if(!isset($_SESSION['eno'])){
  header('Location:signIn.php');
}else if (!isset($_SESSION['sid'])) {
  header('Location:createGRN.php');
}else {
if (isset($_SESSION['pono'])) {
  $pono=$_SESSION['pono'];
}
}
$sid=$_SESSION['sid'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>GRN</title>
  </head>
  <body>
    <?php
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      echo "
        <h1> Material from ".$row['Name']."
      ";
      mysqli_close($con);
    ?>
    <form action="materialOFGRN.php" method="post">
      <table>
        <thead>
          <th>
            Material ID
          </th>
          <th>
            Name
          </th>
          <th>
            Type
          </th>
          <th>
            Value
          </th>
          <th>
            Qty.
          </th>
          <th></th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql1="SELECT * FROM `materials` WHERE `sid` = '".$sid."';";
          $rowSQL1= mysqli_query( $con,$sql1);
          while($row1=mysqli_fetch_assoc( $rowSQL1 )){
            $val=0;
            $checked="";
            if (isset($_SESSION['pono'])) {
              $sql2="SELECT * FROM `purchase_orders` WHERE `po_no` = ".$pono." AND `mid` = ".$row1['mid'].";";
              $rowSQL2= mysqli_query( $con,$sql2);
              if(mysqli_num_rows($rowSQL2)>0){
              $row2 = mysqli_fetch_array( $rowSQL2 );
              $val=$row2['qty'];
              $checked="checked='checked'";
            }
          }
            echo "
              <tr>
                <td>
                  ".$row1['mid']."
                </td>
                <td>
                  ".$row1['Name']."
                </td>
                <td>
                  ".$row1['Type']."
                </td>
                <td>
                  ".$row1['value']."
                </td>
                <td>
                  <input type='number' id='txt".$row1['mid']."' name='txt".$row1['mid']."' value='".$val."' step='1' min='0'>
                </td>
                <td>
                  <input type='checkbox' name='".$row1['mid']."' value='".$row1['mid']."' ".$checked." >
                </td>
              </tr>
            ";
          }
          mysqli_close($con);
        ?>
        <tr>
          <td>
          </td>
          <td>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <input type="submit" name="btnNext" id="btnNext" value="Next" onclick="validateDate()">
          </td>
        </tr>
    </table>
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $rowSQL3= mysqli_query( $con,$sql1);
        $m="";
        $count=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['mid']])){
            $count++;
            $m=$m.$row3['mid'].'x'.$_POST['txt'.$row3['mid']].',';
          }
        }
        if($count==0){
          echo "
          <script type='text/javascript'>
            alert('Select A Material to Order');
            event.preventDefault();
          </script>
          ";
        }else {
          $_SESSION['GRN']=$m;
          header('Location:confirmGRN.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
