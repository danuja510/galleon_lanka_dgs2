<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['sid'])) {
    header('Location:createPurchaseOrders.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PurchaseOrder</title>
    <script type="text/javascript">
      function validateDate(){
        var d=document.getElementById('txtDate').value;
        if (new Date()> new Date(Date.parse(d))) {
          alert("select a valid delivery date");
          event.preventDefault();
        }else {

        }
      }
    </script>
  </head>
  <body>
    <?php
      $sid=$_SESSION['sid'];
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
    <form action="materialsForPO.php" method="post">
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
                  <input type='number' id='txt".$row1['mid']."' name='txt".$row1['mid']."' value='0' step='1' min='0'>
                </td>
                <td>
                  <input type='checkbox' name='".$row1['mid']."' value='".$row1['mid']."' >
                </td>
              </tr>
            ";
          }
          mysqli_close($con);
        ?>
        <tr>
          <td>
            <label for="txtDate">Delivery Date</label>
          </td>
          <td>
            <input type="date" name="txtDate" id="txtDate" required>
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
        $rowSQL2= mysqli_query( $con,$sql1);
        $m="";
        $count=0;
        $date=$_POST['txtDate'];
        while($row2=mysqli_fetch_assoc( $rowSQL2 )){
        /*  if (!empty($_POST['checklist'])) {
            $mat="";
            if(isset($_POST['checklist'])){
              foreach ($_POST['checklist'] as $selected) {
                $mat=$mat.$selected;
              }
            }
          }
          echo "
          <script type='text/javascript'>
            alert('Select A Material to Order');
          </script>
          ";*/
          if(isset($_POST[$row2['mid']])){
            $count++;
            $m=$m.$row2['mid'].'x'.$_POST['txt'.$row2['mid']].',';
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
          $_SESSION['PO']=$m;
          $_SESSION['date']=$date;
          header('Location:confirmPO.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
