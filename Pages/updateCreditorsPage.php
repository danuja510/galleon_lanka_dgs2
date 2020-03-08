<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
  if(!isset($_SESSION['creditors']))
  {
    header('Location:ViewCreditors.php');
  }
 ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Update Creditors</title>
 </head>

 <body>
   <form action="updateCreditorsPage.php" method="post">

     <?php
       $sid=$_SESSION['creditors'];
       $con = mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con)
       {
         die("Error while connecting to database");
       }
       $sql="SELECT * FROM `creditors` WHERE `sid`=".$sid.";";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_array( $rowSQL );

       echo "<h4>Supplier ID: ".$row['sid']."</h4>";
      ?>

    <h3> Update Creditor Details </h3>
    <table>
       <tr>
         <td>
           <label for='txtamount'>Amount No</label>
         </td>
         <td>
           <input type='text' name='txtamount' <?php echo "value='".$row['amount']."'"; ?> id='txtamount'>
         </td>
       </tr>
       <tr>
         <td>
           <label for='txtdate'>Date</label>
         </td>
         <td>
           <input type='text' name='txtdate' <?php echo "value='".$row['date']."'"; ?> id='txtdate'>
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
   $amount=$_POST["txtamount"];
   $date=$_POST["txtdate"];

   $con=mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con)
   {
     die("Cannot connect to DB server");
   }
   $sql="UPDATE `creditors` SET  `amount` = '".$amount."',`date`='".$date."'  WHERE `creditors`.`sid`=".$sid.";";
   mysqli_query($con,$sql);
   mysqli_close($con);
   }
   ?>
 </body>
</html>

<!--jini-->
