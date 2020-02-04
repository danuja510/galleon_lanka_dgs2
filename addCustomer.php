<?php session_start(); ?>
<!DOCTYPE html>
<html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>AddCustomer</title>
  </head>
  <body>
    <form class='' action='index.html' method='post'>
      <table>
        <tr>
          <td>
            <label for='txtName'>Name</label>
          </td>
          <td>
            <input type='text' name='txtName' id='txtName'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtAddress'>Address</label>
          </td>
          <td>
            <input type='text' name='txtAddress' id='txtAddress'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtTPNo'>TP No</label>
          </td>
          <td>
            <input type='text' name='txtTPNo' id='txtTPNo'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtType'>Type</label>
          </td>
          <td>
            <select name='txtType' id='txtType'>
              <option value="other">Other</option>
              <option value="distributor">Distributor</option>
              <option value="dealer">Dealer</option>
              <option value="customer">Customer</option>
            </select>
          </td>
        </tr>
      </table>
    </form>

  </body>
</html>
<!--dan-->
