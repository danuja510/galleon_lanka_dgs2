<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add employee</title>

    <script type="text/javascript">
    function validatePassword()
      {
      var pwd=document.getElementById('txtPwd').value;
      var cpwd=document.getElementById('txtconPwd').value;
      if((pwd.length < 3) || (pwd != cpwd))
        {
						alert("Please enter a correct Password and Confirm password");
						return false;
				}
        return true;
      }
    function Validate()
		  {
					if(validatePassword())
					{
						alert("Registration is completed");
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
      Create account
    </h1>

      <form class="empReg" action="employee.php" method="post" enctype="multipart/form-data">
        <table border="0" align="center">
          <tr>
            <td>Employee number</td>
            <td><input type="text" name="txtEno" value="" placeholder="enter employee number" required></td>
          </tr>
          <tr>
            <td>Name</td>
            <td><input type="text" name="txtName" value="" placeholder="enter name" required></td>
          </tr>
          <tr>
            <td>Designation</td>
            <td><input type="text" name="txtDesignation" value="" placeholder="enter Designation"></td>
          </tr>
          <tr>
            <td>Department</td>
            <td><input type="text" name="txtDepartment" value="" placeholder="enter Department" required></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" name="txtPwd" value="" placeholder="enter a valid password" required></td>
          </tr>
          <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="txtconPwd" value="" placeholder="re-enter the password" required></td>
          </tr>
          <tr>
            <td><input type="submit" name="btnSubmit" onclick="Validate()"></td>
            <td><input type="reset" name="btnReset"></td>
          </tr>
        </table>
      </form>

      <?php
          if(isset($_POST['btnSubmit']))
          {
				 $eno = $_POST['txtEno'];
				 $name = $_POST['txtName'];
				 $des = $_POST['txtDesignation'];
				 $dept = $_POST['txtDepartment'];
         $pwd = $_POST['txtconPwd'];

         $con = mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con)
					{
						die("cannot connect to DB server");
					}
          $sql="INSERT INTO `employees`(`eno`, `Name`, `Designation`, `Dept`, `password`) VALUES ('".$eno."','".$name."','".$des."','".$dept."','".$pwd."')";
          mysqli_query($con,$sql);
				  mysqli_close($con);

        }
       ?>
  </body>
</html>
