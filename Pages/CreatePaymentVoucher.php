<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
 ?>
<html>
<head>
  <meta charset='utf-8'>
    <title>Create Payment Voucher</title>
    <script type="text/javascript">
     function validateSupplier()
     {
       var sid=document.getElementById("txtSid").value;
       if(sid=='___')
       {
         alert('Please select the supplier');
         return false;
       }else{
         return true;
       }
     }

     function Validate()
      {
        if(validateSupplier())
        {}
        else {
          event.preventDefault();
        }
      }


    </script>
</head>

<body>

  <h1> Create Payment Voucher </h1>



  <form action="CreatePaymentVoucher.php" method="post">
    <table>
      <tr>
        <td> <label for="txtDate">Date </label> </td>
        <td> <input type='text' name="txtDate" id="txtDate"></td>
      </tr>
      <tr>
        <td> <label for="lstSupplier"> select Supplier </label> </td>
        <td> <select name="lstSupplier" ud="lstSupplier">
        <option value="___">___</option>
        <?php
              $sql="SELECT * FROM `supplier`;";
              $con=mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error connecting to Database");

              }
              $rowSQL=mysqli_query($con,$sql);
              while($row=mysqli_fetch_assoc($rowSQL))
              {
                echo "<option value'".$row['sid']."'>".$row['sid']."-".$row['Name']."</option>";

              }
              mysqli_close($con);
             ?>
        </select>
      </td>
    </tr>

    <tr>
      <td> <label for="txtGrn">GRN number </label> </td>
      <td> <input type='text'name="txtGrn" id="txtGrn">
    </td>
  </tr>
    <tr>
      <td><label for="txtAmount">Amount </lable></td>
      <td> <input type='text' name="txtAmount" id="txtAmount"> </td>
    </tr>
    <tr>
        <td><input type="submit" name="btnSubmit" value="Submit" onclick="Validate()"></td>
    </tr>
    </table>
    </form>

    <?php
    if(isset($_POST['btnSubmit']))
    {
      $grn_no=$_POST['txtGrn'];
      $sid=$_POST['lstSupplier'];
      $date=$_POST['txtDate'];
      $amount=$_POST['txtAmount'];

      $con1= mysqliconnect("localhost","root","","galleon_lanka");
      if(!$con1)
      {
        die("cannot connect to DB server");
      }
      $sql1="INSERT INTO `payment_voucher`(`grn_no`,`sid`,`date`,`amount`,`prepared_by_(eno)`,`remarks`) VALUES('".$grn_no."','".$sid."','".$date."','".$amount."','','');";
      mysqli_query($con1,$sql1);
      mysqli_close($con1);
    }
   ?>
</body>
</html>
