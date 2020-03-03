<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>EmployeeHome</title>
   </head>
   <body>
     <a href="createPurchaseOrders.php">New Purchase Order</a><br>
     <a href="createGTN.php">New GTN</a><br>
     <a href="createGRN.php">New GRN</a><br>
     <a href="createInvoice.php">New invoice</a><br>
     <a href="#">Manage Purchase Order</a><br>
     <a href="manageGTN.php">Manage GTN</a><br>
     <a href="viewGRN.php">Manage GRN</a><br>
     <a href="manageInvoice.php">Manage invoice</a><br>

   </body>
 </html>
 <!--dan-->
