<?php
 session_start();
 unset($_SESSION['pono']);
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>createGRN</title>
    <script type="text/javascript">
      function validatePO(){
        var po=document.getElementById("txtPO").value;
        if (po=='__') {
          alert('Please Select A Purchase Order No.');
          return false;
        }else{
          return true;
        }
      }
      function validate()
      {
        if(validatePO())
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
            <div class="btn-navi">
              <i class="ion-navicon-round"></i>
            </div>
            <a href="empHome.php">
              <div class="btn-home">
                <i class="ion-home"></i>
                <p>Home</p>
              </div>
            </a>
              <a href="logout.php">
                <div class="btn-logout">
                  <i class="ion-log-out"></i>
                  <p>Logout</p>
                </div>
              </a>
              <a href="#">
                <div class="btn-account">
                    <i class="ion-ios-person"></i>
                    <p>Account</p>
                </div>
              </a>
          </div>
        </div>
    </header>
    <section class="section-select2">
      <form  action="createGRN.php" method="post">
          <div class="row">
            <div class="col span-1-of-2">
                <label for="txtPO">Select Purchase Order</label>
            </div>
            <div class="col span-1-of-2">
                <select name="txtPO" id="txtPO">
                <option value='__'>___</option>
                <?php
                  $sql="SELECT DISTINCT `po_no` FROM `purchase_orders`;";
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $rowSQL= mysqli_query( $con,$sql);
        					while($row=mysqli_fetch_assoc( $rowSQL )){
                    echo "
                      <option value='".$row['po_no']."'>".$row['po_no']."</option>
                    ";
                  }
                  mysqli_close($con);
                 ?>
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
          <div class="row">
              <div class="col span-1-of-1 alt-path">
                  If no purchase order was created <a href="supplierOFGRN.php">click here</a>
              </div>
          </div>
      </form>
      <?php
        if (isset($_POST['btnNext'])) {
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT DISTINCT `sid` FROM `purchase_orders` WHERE `po_no` = ".$_POST['txtPO'].";";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          $_SESSION['pono']=$_POST['txtPO'];
          $_SESSION['sid']=$row['sid'];
          header('Location:materialOFGRN.php');
        }
      ?>
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
