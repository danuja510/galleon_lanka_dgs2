<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reset password</title>
    <script type="text/javascript">
    function validatePassword()
      {
      var pwd=document.getElementById('txtPass').value;
      var cpwd=document.getElementById('txtConPass').value;
      if((pwd.length < 3) || (pwd != cpwd))
        {
						alert("Please enter a correct Password and Confirm password");
						return false;
				}else{
        return true;
      }
      }
      </script>
  </head>
  <body>
    <form action="resetPassword.php" method="post">
      <table>
        <tr>
          <td>
              <label for="txtEno">
                  Eno
              </label>
          </td>
          <td>
              <input type="text" name="txtEno" id="txtEno" required>
          </td>
        </tr>

        <tr>
          <td>
              <label for="txtEmail">
                  Email
              </label>
          </td>
          <td>
              <input type="text" name="txtEmail" id="txtEmail" required>
          </td>
        </tr>

        <tr>
          <td>
              <label for="txtPass">
                  New password
              </label>
          </td>
          <td>
              <input type="password" name="txtPass" id="txtPass" required>
          </td>
        </tr>

        <tr>
          <td>
              <label for="txtConPass">
                  Confirm new password
              </label>
          </td>
          <td>
              <input type="password" name="txtConPass" id="txtConPass" required>
          </td>
        </tr>

        <tr>
          <td>
              <input type="submit" name="btnSubmit" id="btnSubmit" value="Reset Password" onclick="validatePassword()">
          </td>
          <td>
              <input type="reset" name="btnReset" id="btnReset" value="Clear">
          </td>
        </tr>
      </table>
    </form>
    <?php
    if(isset($_POST['btnSubmit']))
       {
         $eno = $_POST['txtEno'];
         $email = $_POST['txtEmail'];
         $pwd= $_POST['txtPass'];
         $cpwd= $_POST['txtConPass'];

         $con = mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con)
            {
                die("cannot connect to DB server");
            }
        $res = mysqli_query("SELECT  `email` FROM `employees` WHERE `eno`='".$eno."'");
        $result = mysql_fetch_array($res);
        echo $result['something'];
        mysqli_query($con);
        mysqli_close($con);
       }
     ?>

  </body>
</html>
<!--sithara--->
