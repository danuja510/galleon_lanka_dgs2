<?php
session_start();
 ?>

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
				}else{
        return true;
      }
      }
    function validateDepartment()
      {
        if(document.getElementById('lstDepartment').value == "----------")
          {
            alert("Please select a Department");
						return false;
          }else{
        return true;
      }
      }
      function validateEmail()
        {
          var em=document.getElementById("txtEmail").value;
          var atposition=em.indexOf("@");
          var dotposition=em.lastIndexOf(".");
          var em1=em.toLowerCase();

          if (atposition<1 || dotposition<atposition+2 || dotposition+2>=em1.length)
            {
            alert("Please enter a valid e-mail address");
            event.preventDefault();
            }
        }
    function Validate()
		  {
					if(validatePassword() && validateDepartment() && validateEmail())
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
            <td><label for='txtName'>Name</label></td>
            <td><input type="text" name="txtName" id="txtName" value="" placeholder="enter name" required></td>
          </tr>
          <tr>
            <td><label for='lstDepartment'>Department</label></td>
            <td>
               <select name="lstDepartment" id="lstDepartment">
               <option value="----------">----------</option>
               <option value="Store">Store</option>
               <option value="Production_floor">Production floor</option>
               <option value="Finished_goods">Finished goods</option>
               </select>
            </td>
          </tr>
          <tr>
            <td><label for='txtPwd'>Password</label></td>
            <td><input type="password" name="txtPwd" id="txtPwd" value="" placeholder="enter a valid password" required></td>
          </tr>
          <tr>
            <td><label for='txtconPwd'>Confirm password</label></td>
            <td><input type="password" name="txtconPwd" id="txtconPwd" value="" placeholder="re-enter the password" required></td>
          </tr>
          <tr>
            <td><input type="submit" name="btnSubmit" id="btnSubmit" onclick="Validate()"></td>
            <td><input type="reset" name="btnReset" id="btnReset"></td>
          </tr>
        </table>
      </form>

      <?php
          if(isset($_POST['btnSubmit']))
        {
				 $name = $_POST['txtName'];
				 $dept = $_POST['lstDepartment'];
         $pwd = $_POST['txtconPwd'];

         $con = mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con)
					{
						die("cannot connect to DB server");
					}
          $sql="INSERT INTO `employees`(`Name`, `Designation`, `Dept`, `password`) VALUES ('".$name."','Manager','".$dept."','".$pwd."')";
          mysqli_query($con,$sql);
				  mysqli_close($con);

        }
       ?>
  </body>
</html>

<!--gima-->
