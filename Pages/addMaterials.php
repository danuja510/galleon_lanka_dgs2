<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>Add Materials</title>

      <script type ="text/javascript">
      function validateSupplier(){
        if(document.getElementById('lstSid').value=="-----")
        {
            alert("please select a supplier");
            return false;
        }
        else
        {
            return true;
        }
      }
      function validateType(){
        if(document.getElementById('lstType').value=="----------")
        {
            alert("please select a type");
            return false;
        }
        else
        {
            return true;
        }
      }
      function validateUname()
        {
          var uname=document.getElementById('txtName').value;
          if(/^\S*$/.test(uname) == false){
            alert("Please enter a valid Material Name (Spaces are not allowed)");
            return false;
          }
          else{
            return true;
          }
        }
    function Validate(){
        if(validateSupplier() && validateType() && validateUname()){
        }
        else {
          event.preventDefault();
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
                <a href="ViewMaterials.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
  <h2>Add Materials</h2>
  <section class="section-add">
        <form action="../PHPScripts/addMaterialsScript.php" method="post">

            <div class='row'>
              <div class='col span-1-of-2'><label for="txtName">Name</label></div>
              <div class='col span-1-of-2'><input type="text" name="txtName" id="txtName" value="" required></div>
            </div>
            <div class='row'>
              <div class='col span-1-of-2'><label for="lstType">Type</label></div>
              <div class='col span-1-of-2'>
                <select name="lstType" id="lstType">
                <option value="----------">----------</option>
                <option value="Raw">Raw</option>
                <option value="Packing">Packing</option>
                <option value="Chemical">Chemical</option>
                </select>
              </div>
            </div>
            <div class='row'>
              <div class='col span-1-of-2'><label for="lstSid">Supplier</label></div>
              <div class='col span-1-of-2'>
                <select name="lstSid" id="lstSid">
                <option value='-----'>-----</option>
                <?php

                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $sql="SELECT * FROM `supplier` where state= 'active';";
                  $rowSQL= mysqli_query( $con,$sql);
                  while($row=mysqli_fetch_assoc( $rowSQL )){
                    echo "
                      <option value='".$row['sid']."'> ".$row['Name']." </option>";
                  }
                  mysqli_close($con);
                 ?>
              </select>

              </div>
            </div>
            <div class='row'>
              <div class='col span-1-of-2'><label for="txtValue">Value</label></div>
              <div class='col span-1-of-2'><input type="number" name="txtValue" id="txtValue" value="" min="0" step="0.01" required></div>
            </div>
            <div class='row'>
              <div class='col span-1-of-2'></div>
              <div class='col span-1-of-2'>
                <input type="Submit" name="btnSubmit" id="btnSubmit" value="Submit" onclick="Validate()">
                <input type="Reset" name="btnReset" id="btnReset" value="Reset">
              </div>
            </div>
        </form>
  </section>

    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>

  </body>
</html>
<!--sithara--->
