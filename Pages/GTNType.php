<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif ($_SESSION['DES']=="Employee"){
   $_SESSION['dept']=$_SESSION['DEPT'];
 } if (!isset($_SESSION['dept'])) {
   header('Location:createGTN.php');
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
    <title>TypeOfGTN</title>
    <script type="text/javascript">
      function validateType(){
        var type=document.getElementById("txtGTNType").value;
        if (type=='__') {
          alert('Please Select A Type');
          return false;
        }else{
          return true;
        }
      }
      function validate()
      {
        if(validateType())
          {}
        else
          event.preventDefault();
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
                <a href="#">
                    <div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div>
                </a>
            </div>
        </div>
    </header>
    <section class="section-select2 cgtn">
        <form action="../PHPScripts/GTNTypeScript.php" method="post">
            <div class="row">
                <div class="col span-1-of-2">
                    <label for="txtGTNType">Select GTN Type</label>
                </div>
                <div class="col span-1-of-2">
                    <select name="txtGTNType" id="txtGTNType">
                    <option value="__">___</option>
                    <option value="in">IN</option>
                    <option value="out">OUT</option>
                  </select>
                </div>
            </div>
            <div class="row next">
                <div class="col span-1-of-2">
                    &nbsp;
                </div>
                <div class="col span-1-of-2">
                  <input type="submit" name="btnNext" value="Next" onclick="validate()">
                </div>
              </div>
        </form>
    </section>
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
<!--dan-->
