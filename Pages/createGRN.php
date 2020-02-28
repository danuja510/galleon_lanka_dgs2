<?php
 session_start();
 unset($_SESSION['pono']);
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>createGRN</title>
    <script type="text/javascript">
      function validatePO(){
        var po=document.getElementById("txtPO").value;
        if (po=='__') {
          alert('Please Select A Purchase Order No.');
          return false;
        }else{
          return true;
        }
      }
      function validate()
      {
        if(validatePO())
          {}
        else
          event.preventDefault();
      }
    </script>
  </head>
  <body>
    <form  action="createGRN.php" method="post">
      <table>
        <tr>
          <td>
            <label for="txtPO">Select Purchase Order</label>
          </td>
        </tr>
        <tr>
          <td>
            <select name="txtPO" id="txtPO">
              <option value='__'>___</option>
              <?php
                $sql="SELECT DISTINCT `po_no` FROM `purchase_orders`;";
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $rowSQL= mysqli_query( $con,$sql);
      					while($row=mysqli_fetch_assoc( $rowSQL )){
                  echo "
                    <option value='".$row['po_no']."'>".$row['po_no']."</option>
                  ";
                }
                mysqli_close($con);
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" name="btnNext" value="Next" onclick="validate()">
          </td>
        </tr>
        <tr>
          <td colspan="2">If no purchase order was created <a href="supplierOFGRN.php">click here</a></td>
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
        $sql="SELECT DISTINCT `sid` FROM `purchase_orders` WHERE `po_no` = ".$_POST['txtPO'].";";
        $rowSQL= mysqli_query( $con,$sql);
        $row = mysqli_fetch_array( $rowSQL );
        $_SESSION['pono']=$_POST['txtPO'];
        $_SESSION['sid']=$row['sid'];
        header('Location:materialOFGRN.php');
      }
    ?>
  </body>
</html>
<!--dan-->
