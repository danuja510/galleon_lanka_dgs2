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
     <a href="createPurchaseOrders.php">New Purchase Order</a>
     <a href="createGTN.php">New GTN</a>
   </body>
 </html>
 <!--dan-->
