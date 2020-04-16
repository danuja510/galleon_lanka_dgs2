<?php
  session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>

<html>
  <head>
    <meta charset='utf-8'>
    <title>BOM</title>
    <script type="text/javascript">
      function validateMaterial()
      {
        var mid=document.getElementById("txtMID").value;
        if(mid=='__')
        {
          alert('Please select the Material ID');
          return false;
        }
        else {
          return true;
        }
      }

      function validateQuantity()
      {
        var q=document.getElementById("txtQuantity").value;

          if(q==null)
          {
            alert('Please enter quantity');
            return false;
          }
          else {
            return true;
          }

      }
      function Validate()
      {
        if(validateMaterial() && validateQuantity())
        {}
        else {
          event.preventDefault();
        }
      }

    </script>
  </head>

  <body>
    <form action="BOM.php" method="post">
      <table>
        <tr>
          <td> <label for="txtDate">Date </label></td>
          <td> <input type='text' name="txtDate" id="txtDate"></td>
        </tr>
        <tr>
          <td> <label for ="txtMID">To </label></td>
          <td><select name="txtMID" id="txtMID">
            <option value="__">__</option>
            <?php
              $sql="SELECT * FROM `materials`;";
              $con=mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error connecting to Database");

              }
              $rowSQL=mysqli_query($con,$sql);
              while($row=mysqli_fetch_assoc($rowSQL))
              {
                echo"<option value'".$row['mid']."'>".$row['Name']."</option>";

              }
              mysqli_close($con);
             ?>
           </select>

          </td>
        </tr>
        <tr>
          <td><label for="txtQuantity">Quantity</label></td>
          <td><input type="Number" name="txtQuantity" id="txtQuantity"></td>
        </tr>
        <tr>
          <td>
          </td>
          <td><input type="submit" name="btnNext" value="Next" onclick="Validate()"></td>
        </tr>
      </table>

    </form>
  </body>
</html>
