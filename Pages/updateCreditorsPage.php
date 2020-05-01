<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
  elseif(!isset($_SESSION['crid']))
  {
    header('Location:ViewCreditors.php');
  }
 ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
   <title>Update Creditors</title>
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
   <form action="updateCreditorsPage.php" method="post">

     <?php
       $crid=$_SESSION['crid'];
       $con = mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con)
       {
         die("Error while connecting to database");
       }
       $sql="SELECT * FROM `creditors` WHERE `crid`=".$crid.";";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_array( $rowSQL );

       echo "<h4>Supplier ID: ".$row['sid']."</h4>";
      ?>

    <h3> Update Creditor Details </h3>
    <table>
       <tr>
         <td>
           <label for='txtamount'>Amount</label>
         </td>
         <td>
           <input type='text' name='txtamount' id='txtamount'>
         </td>
       </tr>
       <tr>
         <td>
           <label for='txtdate'>Date</label>
         </td>
         <td>
           <input type='date' name='txtdate'id='txtdate'>
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
   
   <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>




 </body>
</html>

<!--jini-->
