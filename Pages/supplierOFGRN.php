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
    <title>supplierOFGRN</title>
    <script type="text/javascript">
      function validateSupplier(){
        var sid=document.getElementById("txtSupplier").value;
        if (sid=='__') {
          alert('Please Select A Supplier');
          return false;
        }else{
          return true;
        }
      }
      function validate()
      {
        if(validateSupplier())
          {}
        else
          event.preventDefault();
      }
    </script>
  </head>
  <body>
    <form  action="supplierOFGRN.php" method="post">
      <table>
        <tr>
          <td>
            <label for="txtSupplier">Select Supplier</label>
          </td>
        </tr>
        <tr>
          <td>
            <select name="txtSupplier" id="txtSupplier">
              <option value='__'>___</option>
              <?php
                $sql="SELECT * FROM `supplier`;";
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $rowSQL= mysqli_query( $con,$sql);
      					while($row=mysqli_fetch_assoc( $rowSQL )){
                  echo "
                    <option value='".$row['sid']."'>".$row['Name']."</option>
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
      </table>
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $_SESSION['sid']=$_POST['txtSupplier'];
        header('Location:materialOFGRN.php');
      }
    ?>
  </body>
</html>
<!--dan-->
