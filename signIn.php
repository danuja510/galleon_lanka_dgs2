<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>signIn</title>
  </head>
  <body>
    <h1>Sign In</h1>
    <form action="signIn.php" method="post">
      <table>
        <tr>
          <td>
            <label for="txtENO">Employee No</label>
          </td>
          <td>
            <input type="text" name="txtENO" id="txtENO">
          </td>
        </tr>
        <tr>
          <td>
            <label for="txtPass">Password</label>
          </td>
          <td>
            <input type="password" name="txtPass" id="txtPass">
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" name="btnsubmit" id="btnsubmit" value="Submit">
            <input type="reset" value="Reset" name="btnreset>"
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<!--dan-->
