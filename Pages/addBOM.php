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
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>addBOM</title>
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
      <h2>Add BOM</h2>
    <section class="section-add">
      <form action="../PHPScripts/addBOMScript.php" method="post">
        <div class="row">
                <div class="col span-1-of-2">
                    <label for="txtName">BOM Name</label>
                </div>
                <div class="col span-1-of-2">
                    <input type="text" name="txtName" list="lstBOM" required><br>
                      <datalist id="lstBOM">
                        <?php
                          $con=mysqli_connect("localhost","root","","galleon_lanka");
                          if(!$con){
                            die("Cannot connect to DB server");
                          }
                          $sql="SELECT DISTINCT Name FROM `materials`";
                          $rowSQL= mysqli_query( $con,$sql);
                          while($row=mysqli_fetch_assoc( $rowSQL )){
                            echo "<option value='".$row["Name"]."'>";
                          }
                          mysqli_close($con);
                        ?>
                      </datalist>
                </div>
        </div>
        <div class="row">
                <div class="col span-1-of-2">
                    <label for="txtQty">Qty.</label>
                </div>
                <div class="col span-1-of-2">
                    <input type="number" name="txtQty" min=1 required>
                </div>
        </div>
        <div class="row">
                <div class="col span-1-of-2">
                    &nbsp;
                </div>
                <div class="col span-1-of-2">
                    <input type="submit" name="btnSubmit" value="Next">
                    <button type="submit" id="btnNext" name="btnNext">Add Another Material</button>
                </div>
        </div>
    </form>
    </section>
      <footer>
        <div class="row">
                <p>Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
  </body>
</html>
<!--dan-->
