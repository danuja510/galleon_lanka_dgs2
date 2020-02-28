<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>add materials</title>

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
      function validateType(){
        if(document.getElementById('lstType').value=="----------")
        {
            alert("please select a type");
            return false;
        }
        else
        {
            return true;
        }
      }
    function Validate(){
        if(validateSupplier() &&validateType()){
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
          <td><label for="lstType">Type</label></td>
          <td>
            <select name="lstType" id="lstType">
            <option value="----------">----------</option>
            <option value="Raw">Raw</option>
            <option value="Packing">Packing</option>
            <option value="Chemical">Chemical</option>
            </select>
          </td>
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
          <td><input type="number" name="txtValue" id="txtValue" value="" min="0" step="0.01" required></td>
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
         $Type = $_POST['lstType'];
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
