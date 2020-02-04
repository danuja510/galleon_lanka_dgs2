<?php session_start(); ?>
<!DOCTYPE html>
<html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>AddCustomer</title>
    <script type="text/javascript">
    function validateName()
    {
      var name=document.getElementById("txtName").value;
      if(name=="")
      {
        alert("Enter A Name");
        return false;
      }
      else
        return true;
    }

    function validate(){
      if (validateName()) {
        alert("New Customer Added")
      }else {
        event.preventDefault();
      }
    }
    </script>
  </head>
  <body>
    <h1>Add Customer</h1>
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
        <tr>
          <td></td>
          <td>
            <input type="button" name="btnsubmit" value="Submit" id="btnsubmit" onclick="validate()">
            <input type="reset" name="btnreset" id="btnreset" value="Reset">
          </td>
        </tr>
      </table>
    </form>

  </body>
</html>
<!--dan-->
