<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
 ?>
<!DOCTYPE html>
 <html>
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <script type = "text/javascript">

    function validateCustomer()
    {
      var cno=document.getElementbyId("txtcno").value;
      if (cno=='__')
      {
          alert('Select the Customer');
          return false;
      }
      else {
        return true;
      }
    }

    function validateQuantity()
    {
      var q=document.getElementbyId("txtQuantity").value;
      if (q=="")
        {
          alert("Enter quntity");
          return false;
        }
        else {
          return true;
        }
    }

   function Calculatetotal()
    {

        var q=document.getElementById('txtQuantity');
        var p=document.getElementById('txtUnitPrice');

        var total= q*p;

        document.getElementById('txtTotal').value= total;


    function Validate()
    {
        if(validateCustomer()&&validateQuantity())
        {
          Calculatetotal();
        }
        else
        {
          event.preventDefault();
        }
    }

    </script>
  </head>

  <body>
    <h1 align="center">Invoice</h1>

    <form action ="invoice.php" method ="post">
      <table border="0" align ="center">
        <tr>
          <td><lable for="txtcno">Select Customer</label></td>
          <td><input type="text" name="txtcno" id="txtcno" value=""></td>
        </tr>
        <tr>
          <td><label for= "txtItemNo">Item No</label></td>
          <td><input type="text" name="txtItemNo" id="txtItemNo" value=""></td>
        </tr>
        <tr>
          <td><label for="txtQuantity">Quantity</label></td>
          <td><input type="number" name="txtQuantity" id="txtQuantity" value=""></td>
        </tr>
        <tr>
          <td><label for="txtUnitPrice">Unit Price</label></td>
          <td><input type="number" name="txtUnitPrice" id="txtUnitPrice" value=""></td>
        </tr>


        <tr>
          <td><label>Prepared by</label></td>
          <td><input type="text" name="txtPreparedBy" id="txtPreparedBy" value=""></td>
        </tr>
        <tr>
          <td><label>Approved by </label></td>
          <td><input type="text" name="txtApprovedBy"  id="txtApprovedBy" value=""></td>
        </tr>
        <tr>
          <td><label>Vehicle Number</label></td>
          <td><input type="text" name="txtVehicleNo" id="txtVehicleNo" value=""></td>
        </tr>
        <tr>
            <td><input type="Submit" name="btnSubmit" id="btnSubmit" value="Add" onclick="Validate()">Create Invoice</button>
            <td><input type="Reset" name="btnReset" id="btnReset" value="Reset"></button></td>
        </tr>

        <tr>
          <td><label for="txtTotal">Sub Total</label></td>
          <td><input type="text" name="lblTotal" id="lblTotal" value=""></td>
        </tr>

        <tr>
        </tr>
      </table>
    </form>
  </body>
 </html>
<!--jini-->
