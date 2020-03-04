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
    <title>createInvoice</title>
    <script type="text/javascript">
    function validateCustomer(){
      var cno=document.getElementById("txtCNO").value;
      if (cno=='__') {
        alert('Please Select A Customer');
        return false;
      }else{
        return true;
      }
    }
    function validate()
    {
      if(validateCustomer())
        {}
      else
        event.preventDefault();
    }
    </script>
  </head>
  <body>
    <form action="createInvoice.php" method="post">
    <label for="txtCNO">Select Customer</label>
    <select name="txtCNO" id="txtCNO">
      <option value="__">___</option>
      <?php
      $sql="SELECT * FROM `customer`;";
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $rowSQL= mysqli_query( $con,$sql);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        echo "
          <option value='".$row['cno']."'>".$row['cno']."-".$row['Name']."</option>
        ";
      }
      mysqli_close($con);
      ?>
    </select>
      <table>
        <thead>
          <th>Item No.</th>
          <th>Available Qty.</th>
          <th>Qty. to be Sold</th>
          <th></th>
        </thead>
        <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='fGoods'AND `type`='finished product' GROUP BY `item_no`,`type`;;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        while($row=mysqli_fetch_assoc( $rowSQL )){
          echo "
            <tr>
              <td>".$row['item_no']."</td>
              <td>".$row['Qty']."</td>
              <td><input type='number' id='txt".$row['item_no']."' name='txt".$row['item_no']."' step='1' min='0' max='".$row['Qty']."' value='0'></td>
              <td><input type='checkbox' name='".$row['item_no']."' value='".$row['item_no']."' ></td>
            </tr>
          ";
        }
        ?>
      </table>
      <input type="submit" name="btnNext" id="btnNext" value="Next" onclick="validate()">
      </form>
      <?php
        if (isset($_POST['btnNext'])) {
          $_SESSION['cno']=$_POST['txtCNO'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $rowSQL3= mysqli_query( $con,$sql);
          $m="";
          $count=0;
          while($row3=mysqli_fetch_assoc( $rowSQL3 )){
            if(isset($_POST[$row3['item_no']])){
              $count++;
              $m=$m.$row3['item_no'].'x'.$_POST['txt'.$row3['item_no']].',';
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
            $_SESSION['INVOICE']=$m;
            header('Location:confirmInvoice.php');
          }
        }
      ?>
  </body>
</html>
<!--dan-->
