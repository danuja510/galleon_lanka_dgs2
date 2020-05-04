<?php
session_start();
if(!isset($_SESSION['reset']))
  {
    header('Location:resetPassword.php');
  }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>create new password</title>
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
     <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
     <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
     <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
     <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">

     <script type="text/javascript">
     function validatePassword()
       {
       var pwd=document.getElementById('txtPwd').value;
       var cpwd=document.getElementById('txtconPwd').value;
       if(pwd != cpwd)
         {
 						alert("Please enter a valid Password and Confirm password");
 						//return false;
            event.preventDefault();
 				 }
        else
        {
            //return true;
        }
       }
      </script>

   </head>
   <body>
     <header>
           <div class="row">
               <h1>Manufacturing Management System</h1>
               <h3>Galleon Lanka PLC</h3>
           </div>
           <div class="nav">
               <div class="row">
                   <div class="btn-navi"><i class="ion-navicon-round"></i></div>
                   <a href="empHome.php">
                       <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                   </a>
                   <a href="logout.php">
                       <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                   </a>
                   <a href="#"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
               </div>
           </div>
       </header>

       <section class="section-view">
             <h2>New Password</h2>
       <form action="../PHPScripts/newPasswordScript.php" method="post">
          <div class="row">
       <table>
         <div class="row">
           <div class="col span-1-of-2">
               <label for="txtpwd">
                   New Password
               </label>
           </div>
           <div class="col span-1-of-2">
               <input type="password" name="txtPwd" id="txtPwd" value="" minlength="5" required>
           </div>
         </div>

         <div class="row">
           <div class="col span-1-of-2">
               <label for="txtconPwd">
                   Confirm New Password
               </label>
           </div>
           <div class="col span-1-of-2">
               <input type="password" name="txtconPwd" id="txtconPwd" value="" minlength="5" required>
           </div>
         </div>

         <div class='row'>
           <div class='col span-1-of-2'></div>
           <div class='col span-1-of-2'>
             <input type="Submit" name="btnSubmit" id="btnSubmit" value="Submit" onclick="validatePassword()">
             <input type="Reset" name="btnReset" id="btnReset" value="Reset">
           </div>
         </div>
       </table>
     </form>
</section>
<footer>
    <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
    <div class="row"><p>Designed and Developed by DGS2</p></div>
</footer>

   </body>
 </html>
<!--sithara-->
