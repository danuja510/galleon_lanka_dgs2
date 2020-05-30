<?php
session_start();
if(!isset($_SESSION['eno'])){
  header('Location:signIn.php');
}elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
 ?>
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Supplier</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">

    <script type ="text/javascript">
    function validateTelephone()
      {
      var tp=document.getElementById('txtTno').value;
      var c=tp.length;
      if(c !=10 && isNaN())
        {
          alert("enter a valid telephone number");
          event.preventDefault();
        }
        else
        {

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
    <h2>Add  Supplier</h2>
    <section class="section-add">
    <form action="../PHPScripts/addSupplierScript.php" method="post">
  <div class="row">
      <div class="col span-1-of-2"><label for='txtName'>Name</label></div>
      <div class="col span-1-of-2"><input type="text" name="txtName" id="txtName" value="" required></div>
    </div>
    <div class="row">
      <div class="col span-1-of-2"><label for='txtAddress'>Address</label></div>
      <div class="col span-1-of-2"><input type="text" name="txtAddress" id="txtAddress" value="" required></div>
    </div>
    <div class="row">
      <div class="col span-1-of-2"><label for='txtTno'>Telephone number</label></div>
      <div class="col span-1-of-2"><input type="text" name="txtTno" id="txtTno" value="" required></div>
    </div>
    <div class="row">
      <div class="col span-1-of-2"></div>
      <div class="col span-1-of-2">
        <input type="Submit" name="btnSubmit" id="btnSubmit" value="Add" onclick="validateTelephone()">
        <input type="Reset" name="btnReset" id="btnReset" value="Reset"></div>
    </div>


</form>
</section>

<footer>
    <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
    <div class="row"><p>Designed and Developed by DGS2</p></div>
</footer>

</body>
</html>

<!--sithara-->
