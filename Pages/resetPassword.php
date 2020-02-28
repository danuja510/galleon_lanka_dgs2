<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reset password</title>
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

      </table>

    </form>

  </body>
</html>
