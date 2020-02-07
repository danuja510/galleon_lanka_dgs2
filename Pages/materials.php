 <?php
session_start();
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>materials</title>

      <script type ="text/javascript">
      </script>

  </head>
  <body>
    <h1 align="center">
      Add materials
    </h1>
    <form class="" action="materials.php" method="post">
      <table border="0" align="center">
          <tr>
          <td><label for='txtName'>Name</label></td>
          <td><input type="text" name="txtName" id="txtName" value=""></td>
        </tr>
        <tr>
          <td><label for='txtType'>Type</label></td>
          <td><input type="text" name="txtType" id="txtType" value=""></td>
        </tr>
        <tr>
          <td><label for='txtValue'>value</label></td>
          <td><input type="text" name="txtValue" id="txtValue" value=""></td>
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
         $Value= $_POST['txtValue'];

 $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("cannot connect to DB server");
        }
         $sql="INSERT INTO `materials` (`mid`, `Name`, `Type`, `sid`, `value`) VALUES ('".$Name."','".$Type."','".$Value."')";
        mysqli_query($con,$sql);
        mysqli_close($con);

       }
     ?>

  </body>
</html>
<!--sithara--->
