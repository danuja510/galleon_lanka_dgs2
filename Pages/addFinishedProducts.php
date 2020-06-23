<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
 if ($_SESSION['DEPT']=='store'){
  header('Location:empHome.php');
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Finished products</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <script type="text/javascript">

        function validateBom(){
          if(document.getElementById('lstBom').value=="-----")
          {
              alert("please select a BOM");
              return false;
          }
          else{
              return true;
          }
      }
      function validateName()
        {
          var uname=document.getElementById('txtName').value;
          if(/^\S*$/.test(uname) == false){
            alert("Please enter a valid Product Name (Spaces are not allowed)");
            return false;
          }
          else{
            return true;
          }
        }

      function Validate(){
        if(validateBom() && validateName() )
        {}
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
                <!-- <div class="btn-navi"><i class="ion-navicon-round"></i></div> -->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="viewFinishedProducts.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>

    <h2>Add Finished Product</h2>
    <section class="section-add">
    <form action="../PHPScripts/addFinishedProductsScript.php" method="post">

        <div class="row">
            <div class="col span-1-of-2">
              <label for="txtName">Name</label>
            </div>
            <div class="col span-1-of-2">
              <input type="text" name="txtName" id="txtName" value="" required>
            </div>
        </div>


        <div class="row">
            <div class="col span-1-of-2">
              <label for="lstBom">BOM ID</label>
            </div>
            <div class="col span-1-of-2">
                <select name="lstBom" id="lstBom">
                  <option value='-----'>-----</option>
                  <?php
                    $sql="SELECT DISTINCT `bom_id` FROM `bom` WHERE `state` = 'active';";
                    $con = mysqli_connect("localhost","root","","galleon_lanka");
                    if(!$con)
                    {
                      die("Error while connecting to database");
                    }
                    $rowSQL= mysqli_query( $con,$sql);
                    mysqli_close($con);
                    while($row=mysqli_fetch_assoc( $rowSQL )){
                      echo "
                        <option value='".$row['bom_id']."'> ".$row['bom_id']." </option>
                      ";
                    }
                  ?>
                </select>
            </div>
          </div>

            <div class="row">
              <div class="col span-1-of-2">
                <label for="txtValue">Value</label>
              </div>
              <div class="col span-1-of-2">
                <input type="number" name="txtValue" id="txtValue" value="" min="0" step="0.01" required>
              </div>
            </div>

            <div class="row">
            <div class="col span-1-of-2">
              &nbsp;
            </div>
            <div class="col span-1-of-2">
              <input type="submit" name="btnSubmit" id="btnSubmit" onclick="Validate()">
              <input type="reset" name="btnReset" id="btnReset">
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

<!--gima-->
