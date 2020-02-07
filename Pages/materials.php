<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>materials</title>

      <script type ="text/javascript">
      function validateSupplier(){
        if(document.getElementById('lstSid').value=="-----")
        {
            alert("please select a supplier");
            return false;
        }
        else
        {
            return true;
        }
      }

      function validateValue(){
        var value=document.getElementById('txtValue').value;
        if(!isNaN(value)){
        return true;
      }
      else {
        alert("enter a valid value");
        return false;
      }
    }
    function Validate(){
        if(validateSupplier() && validateValue()){
          alert("Material added");
        }
        else {
          event.preventDefault();
        }
      }
      </script>

  </head>
  <body>
    <h1 align="center">
      Add materials
    </h1>
    <form class="" action="materials.php" method="post">
      <table border="0" align="center">
          <tr>
          <td><label for="txtName">Name</label></td>
          <td><input type="text" name="txtName" id="txtName" value="" required></td>
        </tr>
        <tr>
          <td><label for="txtType">Type</label></td>
          <td><input type="text" name="txtType" id="txtType" value="" required></td>
        </tr>
        <tr>
          <td><label for="lstSid">Supplier</label></td>
          <td>
            <select name="lstSid" id="lstSid">
            <option value='-----'>-----</option>
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
                  <option value='".$row['sid']."'> ".$row['Name']." </option>";
              }
              mysqli_close($con);
             ?>
          </select>

          </td>
        </tr>
        <tr>
          <td><label for="txtValue">value</label></td>
          <td><input type="text" name="txtValue" id="txtValue" value="" required></td>
        </tr>
        <tr>
          <td><input type="Submit" name="btnSubmit" id="btnSubmit" value="Submit" onclick="Validate()"></td>
          <td><input type="Reset" name="btnReset" id="btnReset" value="Reset"></td>
        </tr>
        </<table>
    </form>

    <?php
    if(isset($_POST['btnSubmit']))
       {
         $Name = $_POST['txtName'];
         $Type = $_POST['txtType'];
         $sid = $_POST['lstSid'];
         $Value= $_POST['txtValue'];

 $con1 = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con1)
        {
          die("cannot connect to DB server");
        }
         $sql1="INSERT INTO `materials` (`Name`, `Type`, `sid`, `value`) VALUES ('".$Name."','".$Type."','".$sid."','".$Value."')";
        mysqli_query($con1,$sql1);
        mysqli_close($con1);
       }
     ?>
  </body>
</html>
<!--sithara--->
