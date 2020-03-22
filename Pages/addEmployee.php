<?php
session_start();
if(!isset($_SESSION['eno'])){
  header('Location:signIn.php');
}
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
          }
          else
          {
        return true;
          }
      }
      function validateEmail()
        {
          var em=document.getElementById("txtEmail").value;
          var atposition=em.indexOf("@");
          var dotposition=em.lastIndexOf(".");
          //var em1=em.toLowerCase();

          if (atposition<1 || dotposition<atposition+2 || dotposition+2>=em.length)
            {
              alert("Please enter a valid e-mail address");
              return false;
            }
            else
            {
              return true;
            }
        }
    function Validate()
		  {
					if(validatePassword() && validateDepartment() && validateEmail())
					{

					}
					else
					{
						event.preventDefault();
					}
			}
    </script>
  </head>

  <body>
    <h1>
      Create account
    </h1>

      <form  action="addEmployee.php" method="post" >

        <table>
          <tr>
            <td>
              <label for='txtName'>
                Name
              </label>
            </td>
            <td>
              <input type="text" name="txtName" id="txtName" value="" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='lstDepartment'>
                Department
              </label>
            </td>
            <td>
               <select name="lstDepartment" id="lstDepartment">
               <option value="----------">----------</option>
               <option value="store">Store</option>
               <option value="pFloor">Production floor</option>
               <option value="fGoods">Finished goods</option>
               </select>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtEmail'>
                Email
              </label>
            </td>
            <td>
              <input type="email" name="txtEmail" id="txtEmail" value="" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtPwd'>
                Password
              </label>
            </td>
            <td>
              <input type="password" name="txtPwd" id="txtPwd" value="" placeholder="enter a valid password" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtconPwd'>
                Confirm password
              </label>
            </td>
            <td>
              <input type="password" name="txtconPwd" id="txtconPwd" value="" placeholder="re-enter the password" required>
            </td>
          </tr>
          <tr>
            <td>
              <input type="submit" name="btnSubmit" id="btnSubmit" onclick="Validate()">
            </td>
            <td>
              <input type="reset" name="btnReset" id="btnReset">
            </td>
          </tr>
        </table>

      </form>

      <?php
          if(isset($_POST['btnSubmit']))

        {

				 $name = $_POST['txtName'];
				 $dept = $_POST['lstDepartment'];
         $pwd = $_POST['txtconPwd'];
         $email=$_POST['txtEmail'];

         $con1 = mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con1)
					{
						die("cannot connect to DB server");
					}
          $sql1="INSERT INTO `employees`(`Name`, `Designation`, `Dept`, `password`,`email`,`status`) VALUES ('".$name."','Employee','".$dept."','".$pwd."','".$email."','active');";
          mysqli_query($con1,$sql1);
				  mysqli_close($con1);

        }
       ?>
  </body>
</html>

<!--gima-->
