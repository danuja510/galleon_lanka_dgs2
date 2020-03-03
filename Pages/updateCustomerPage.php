<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
  if(!isset($_SESSION["customer"]))
  {
    header('Location:ViewCustomer.php');
  }

 ?>


 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update Customer</title>
  </head>
  <body>
    <form action="updateCustomerPage.php" method="post">
      <h2> Current Details </h2>
      <?php
        $cno=$_SESSION['customer'];
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `customer` WHERE `cno`=".$cno.";";
        $rowSQL= mysqli_query( $con,$sql);
      	$row = mysqli_fetch_array( $rowSQL );

        echo "<h4>Customer Number: ".$row['cno']."</h4>";
       ?>

       <h2> Update Details </h2>
     <table>
        <tr>
          <td>
            <label for='txtName'>Name</label>
          </td>
          <td>
            <input type='text' name='txtName' <?php echo "value='".$row['Name']."'"; ?> id='txtName'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtAddress'>Address</label>
          </td>
          <td>
            <input type='text' name='txtAddress' <?php echo "value='".$row['Address']."'"; ?> id='txtAddress'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtTPNo'>TP No</label>
          </td>
          <td>
            <input type='text' name='txtTPNo' <?php echo "value='".$row['tpno']."'"; ?> id='txtTPNo'>
          </td>
        </tr>
        <tr>
          <td>
            <label for='txtType'>Type</label>
          </td>
          <td>
            <select name='txtType'  id='txtType'>
              <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
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
            <button type="submit" name="btnsubmit" id="btnsubmit" onclick="validate()">Submit</button>
            <input type="reset" name="btnreset" id="btnreset" value="Reset">
          </td>
        </tr>
      </table>
    </form>
    <?php
    if(isset($_POST["btnsubmit"]))
    {
    $name=$_POST["txtName"];
    $address=$_POST["txtAddress"];
    $tpno=$_POST["txtTPNo"];
    $type=$_POST["txtType"];

    $con=mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Cannot connect to DB server");
    }
    $sql="UPDATE `customer` SET `Name` = '".$name."', `Address` = '".$address."',`tpno`='".$tpno."', `type`= '".$type."' WHERE `customer`.`cno`=".$cno.";";
    mysqli_query($con,$sql);
		mysqli_close($con);
    }
    ?>
  </body>
 </html>

 <!--jini-->
