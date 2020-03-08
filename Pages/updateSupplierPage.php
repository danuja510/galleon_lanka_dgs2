<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
  if(!isset($_SESSION['supplier']))
  {
    header('Location:ViewSuppliers.php');
  }
 ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Update Supplier</title>
 </head>

 <body>
   <form action="updateSupplierPage.php" method="post">
     <h2> Current Details </h2>

     <?php
       $sid=$_SESSION['supplier'];
       $con = mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con)
       {
         die("Error while connecting to database");
       }
       $sql="SELECT * FROM `supplier` WHERE `sid`=".$sid.";";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_array( $rowSQL );

       echo "<h4>Supplier ID: ".$row['sid']."</h4>";
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
         <td></td>
         <td>
           <button type="submit" name="btnsubmit" id="btnsubmit">Submit</button>
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

   $con=mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con)
   {
     die("Cannot connect to DB server");
   }
   $sql="UPDATE `supplier` SET `Name` = '".$name."', `Address` = '".$address."',`tpno`='".$tpno."'  WHERE `supplier`.`sid`=".$sid.";";
   mysqli_query($con,$sql);
   mysqli_close($con);
   }
   ?>
 </body>
</html>

<!--jini-->
