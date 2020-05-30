<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
  elseif (!isset($_SESSION['grn']))
  {
    header('Location:grnForCreatePV.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/PVStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>Create Payment Voucher</title>
    <script type="text/javascript">

      function validateDate(){
        var d=document.getElementById('txtDate').value;
        if (new Date()< new Date(Date.parse(d))) {
          alert("Select a valid date");
          return false;
        }
        else
        {
          return true;
        }
      }

      function Validate()
      {
        if(validateDate())
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
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="grnForCreatePV.php">
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
        $sid=$_SESSION['sid'];
        $grn_no =$_SESSION['grn'];
        $con = mysqli_connect("localhost","root","","galleon_lanka");
if(!$con)
{
  die("Error while connecting to database");
}
$sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
$rowSQL= mysqli_query( $con,$sql);
$row = mysqli_fetch_array( $rowSQL );
echo "<h2> Payment Voucher to ".$row['Name']."</h2>";
mysqli_close($con);
      ?>
    <section class="section-add">
      <div class="row">
        <div class="col span-2-of-2">

          <form action="../PHPScripts/CreatePaymentVoucher2Script.php" method="post">

                  <?php
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $sql="SELECT MAX(pv_no) AS max FROM `payment_voucher`;";
                  $rowSQL = mysqli_query($con,$sql);
                  $row = mysqli_fetch_array($rowSQL);
                  $max=$row['max'];
                  mysqli_close($con);
                  $pv_no=$max+1;
                  ?>

              <div class="row">
                <div class="col span-1-of-2">
                  <label>PV number </label>
                </div>
                <div class="col span-1-of-2">
                  <input type='text'name="txtPVno" id="txtPVno" <?php echo "value= '".$pv_no."' "; ?> readonly >
                </div>
              </div>

              <div class="row">
                <div class="col span-1-of-2">
                  <label for="txtGRN">GRN No. </label>
                </div>
                <div class="col span-1-of-2">
                  <input type='text' name="txtGRN" id="txtGRN" <?php echo "value= '".$grn_no."' "; ?> readonly>
                </div>
              </div>

              <div class="row">
                <div class="col span-1-of-2">
                  <label for="txtDate">Date </label>
                </div>
                <div class="col span-1-of-2">
                  <input type='date' name="txtDate" id="txtDate" required>
                </div>
              </div>

              <div class="row">
                <div class="col span-1-of-2">
                  <label for="txtAmount">Amount </label>
                </div>
                <div class="col span-1-of-2">
                    <?php
                      $con = mysqli_connect("localhost","root","","galleon_lanka");
                      if(!$con)
                      {
                        die("Error while connecting to database");
                      }
                      $sql="select grn_no,SUM(amount) as value from grn where grn_no='".$grn_no."' group by grn_no";
                      $rowSQL = mysqli_query($con,$sql);
                      $row = mysqli_fetch_array($rowSQL);
                      echo "<input type='number' name='txtAmount' id='txtAmount' min='0' max='".$row['value']."' value='".$row['value']."' required>";
                    ?>
                </div>
              </div>

              <div class="row">
                <div class="col span-1-of-2">
                  <label for="txtRemarks">Remarks </label>
                </div>
                <div class="col span-1-of-2">
                  <input type='text' name="txtRemarks" id="txtRemarks" >
                </div>
              </div>
              <div class="row">
                  <div class="col span-1-of-2">
                      &nbsp;
                  </div>
                  <div class="col span-1-of-2">
                    <input type="submit" name="btnSubmit" value="Submit" onclick="Validate()">
                  </div>
              </div>

            </form>
          </div>
        </div>
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
<!--jini-->
