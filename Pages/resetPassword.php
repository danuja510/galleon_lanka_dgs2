<?php
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>reset pwd</title>

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
            <input type="text" name="txtEno" id="txtEno" value="" required>
        </td>
      </tr>

      <tr>
        <td>
            <label for="txtEmail">
                Email
            </label>
        </td>
        <td>
            <input type="email" name="txtEmail" id="txtEmail" value="" required>
        </td>
      </tr>

      <tr>
        <td>
            <input type="submit" name="btnSubmit" value="Confirm">
            <input type="reset" name="btnreset" value="Reset">
        </td>
      </tr>
    </table>
    </form>

    <?php
    if(isset($_POST['btnSubmit']))
    {
      $eno=$_POST['txtEno'];
      $email=$_POST['txtEmail'];
      $sql="SELECT * FROM `employees` WHERE `eno` = ".$eno." AND `email` LIKE '".$email."';";
      $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $result= mysqli_query($con,$sql);
        mysqli_close($con);
      if(mysqli_num_rows($result)>0)
        {
        $_SESSION['reset']=$eno;
        header('Location:newPassword.php');
        echo"hi";
        }
        else
        {
          echo "invalid credentials";
        }
    }

     ?>

  </body>
</html>
<!--sithara-->