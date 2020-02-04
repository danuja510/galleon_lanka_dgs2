<?php
session_start();
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Supplier</title>

    <script type ="text/javascript">
    function validateTelephone()
    {
      var tp=document.getElementById('txtTno').value;
      var c=tp.length;
      if(c !=10)
      {
        {
          alert("enter a valid telephone number");
          return false;
        }
      return true;
    }
  }
  function Validate()
		  {
					if(validateTelephone())
					{
						alert("completed");
					}
					else
					{
						event.preventDefault();
					}
			}

  </script>
  </head>
  <body>
    <h1 align="center">
    Supplier Registration
    </h1>
<form class="supplier" action="supplier.php" method="post">
  <table border="0" align="center">
    <tr>
      <td>Supplier ID </td>
      <td><input type="text" name="txtSid" id="txtSid" value=""></td>
    </tr>
    <tr>
      <td>name</td>
      <td><input type="text" name="txtName" id="txtName" value=""></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><input type="text" name="txtAddress" id="txtAddress" value=""></td>
    </tr>
    <tr>
      <td>Telephone Number</td>
      <td><input type="text" name="txtTno" id="txtTno" value=""></td>
    </tr>
    <tr>
      <td><input type="Submit" name="btnSubmit" id="btnSubmit" value="Add" onclick="Validate()"></td>
      <td><input type="Reset" name="btnReset" id="btnReset" value="Reset"></td>
    </tr>

  </table>
</form>
<?php

 if(isset($_POST['btnSubmit']))
 {

				 $sid = $_POST['txtSid'];
				 $name = $_POST['txtName'];
				 $Address = $_POST['txtAddress'];
				 $Tno = $_POST['txtTno'];


$con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
         {
           die("cannot connect to DB server");
         }
         $sql="INSERT INTO `Supplier`(`sid`, `Name`, `Address`, `tpno`) VALUES ('".$sid."','".$name."','".$Address."','".$Tno."')";
                mysqli_query($con,$sql);
      				  mysqli_close($con);
    }
  ?>
  </body>
</html>

<!--sithara-->
