<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='pFloor'){
    header('Location:empHome.php');
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
    <title>Create Cash Receipt</title>
    <script type="text/javascript">
      function validateIno(){
        var ino=document.getElementById("txtIno").value;
        if (ino=='__') {
          alert('Please Select An Invoice');
          return false;
        }else{
          return true;
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
                <a href="viewCashreceipt.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
      <section class="section-select2">
        <form  action="../PHPScripts/createCashReceiptScript.php" method="post">
            <div class="row">
                <div class="col span-1-of-2">
                    <label for="txtIno">Select Invoice</label>
                </div>
                <div class="col span-1-of-2">
                    <select name="txtIno" id="txtIno">
                      <option value='__'>___</option>
                      <?php
                        $sql="SELECT * FROM `invoice` where approved_by is not null GROUP BY `invoice_no` ;";
                        $con = mysqli_connect("localhost","root","","galleon_lanka");
                        if(!$con)
                        {
                          die("Error while connecting to database");
                        }
                        $rowSQL= mysqli_query( $con,$sql);
                                while($row=mysqli_fetch_assoc( $rowSQL )){
                          echo "
                            <option value='".$row['invoice_no']."'>".$row['invoice_no']."</option>
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
              <input type="submit" name="btnNext" value="Next" onclick="validateIno()">
            </div>
          </div>
          <div class="row">
              <div class="col span-1-of-1 alt-path">
                  If new Invoice <a href="createInvoice.php">click here</a>
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
<!--sithara-->
