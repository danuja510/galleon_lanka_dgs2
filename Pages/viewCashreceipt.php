<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='pFloor'){
    header('Location:empHome.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>view cash receipt</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
</head>
<body>
  <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="empHome.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>

  <section class="section-manage">
    <div class="row">
      <div class="col span-1-of-7">
        <a href="createCashReceipt.php">
          <div class="new">
            <i class="ion-ios-compose-outline"></i>
            New Cash &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receipt
          </div>
        </a>
      </div>
      <div class="col span-6-of-7">
    <form action="../PHPScripts/viewCashreceiptScript.php" method="post">
    <table>
    <tr>
        <th>
          CR_no
        </th>
        <th>
          Invoice no.
        </th>
        <th>
          C No.
        </th>
        <th>
          Amount
        </th>
        <th>
          Prepared by
        </th>
        <th>
          Approved by
        </th>
        <th>
          Remarks
        </th>
        <th>
          Date
        </th>
        <th>
          Status
        </th>
    </tr>

    <?php
         $con=mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con)
           {
             die("cannot connect to DB server");
           }

           $sql="SELECT * FROM `cash_receipts`";
           $rowSQL=mysqli_query($con,$sql);
           while($row=mysqli_fetch_array($rowSQL))
           {
             if($row['approved_by']!=null){
               $approve='Approved';
             }else{
               $approve='Pending';
             }
   echo"
       <tr>
           <td>
               ".$row['cr_no']."
           </td>
           <td>
               ".$row['invoice_no']."
           </td>
           <td>
               ".$row['cno']."
           </td>
           <td>
               ".$row['amout']."
           </td>
           <td>
               ".$row['prepared_by']."
           </td>
           <td>
               ".$row['approved_by']."
           </td>
           <td>
               ".$row['remarks']."
           </td>
           <td>
               ".$row['date']."
           </td>
           <td>
               ".$approve."
           </td>
           <td class='bt'>
               <input type='submit' name='".$row['cr_no']."' value='view'>
           </td>
       </tr>
   ";
           }
       ?>
       </table>
       </form>
     </div>
   </div>
</section>
<footer>

    <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
    <div class="row"><p>Designed and Developed by DGS2</p></div>
</footer>
   </body>
   </html>
   <!--sithara-->
