<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
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
   <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
   <title>Update Supplier</title>
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
                <a href="ViewSuppliers.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
     <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
          {
           die("cannot connect to DB server");
          }
         $sql="SELECT * FROM `supplier` where `sid`='".$_SESSION['supplier']."';";
         $rowSQL= mysqli_query( $con,$sql);
         $row = mysqli_fetch_assoc( $rowSQL);
         $st=$row['state'];
         $readonly="";
         if($st=='inactive'){
            $readonly="readonly";
         }
        echo "
        <section class ='section-manage'>
        <h2>Manage Supplier</h2>
      <div class ='row'>
          <form action='../PHPScripts/updateSupplierPageScript.php' method='post'>";
              $sid=$_SESSION['supplier'];
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `supplier` WHERE `sid`=".$sid.";";
              $rowSQL= mysqli_query( $con,$sql);
              $row = mysqli_fetch_array( $rowSQL );

              echo "<div class='row'>
               <div class='col span-1-of-2'>
                  <label for='txtSID'>Supplier ID:</label>
                </div>
                <div class='col span-1-of-2'> <input type='number' name='txtSID' value='".$row['sid']."' id='txtSID' readonly required>
                </div>
            </div>";
              mysqli_close($con);
             echo "
             <div class='row'>
               <div class='col span-1-of-2'>
                  <label for='txtName'>Name</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtName' value='".$row['Name']."' id='txtName' ".$readonly." required>
                </div>
            </div>

            <div class='row'>
              <div class='col span-1-of-2'>
                  <label for='txtAddress'>Address</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtAddress' value='".$row['Address']."' id='txtAddress' ".$readonly." required>
                </div>
            </div>

              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtTPNo'>TP No</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtTPNo' value='".$row['tpno']."' id='txtTPNo' ".$readonly." required>
                </div>
            </div>
            <div class='row'>
                <div class='col span-1-of-2'>
                    &nbsp;
            </div>
            <div class='col span-1-of-2'>";
            if($st=='active'){
                echo "<input type='submit' name='btnsubmit' id='btnsubmit' value='Submit'>
                <input type='submit' name='btnDelete' id='btnDelete' value='Delete Supplier'>";
            }
              echo "  
            </div>
          </div>
          
          </form>
      </div>
    </section>";
     ?>
   <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
 </body>
</html>

<!--jini-->
