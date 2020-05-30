<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset='utf-8'>
  <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>Create Payment Voucher</title>
    <script type="text/javascript">
     function validateSupplier()
     {
       var sid=document.getElementById("lstSupplier").value;
       if(sid=='___')
       {
         alert('Please select the supplier');
         return false;
       }else{
         return true;
       }
     }

     function Validate()
      {
        if(validateSupplier())
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
                <a href="viewPaymentVoucher.php">
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
    <form action="../PHPScripts/createPaymentVoucherScript.php" method="post">
        <div class="row">
          <div class="col span-1-of-2">
              <label for="lstSupplier">Select Supplier</label>
          </div>
          <div class="col span-1-of-2">
            <select name="lstSupplier" id="lstSupplier">
              <option value = "___">___</option>
              <?php
                $sql="SELECT * FROM `supplier` where state='active';";
                $con=mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error connecting to Database");

                }
                $rowSQL=mysqli_query($con,$sql);
                while($row=mysqli_fetch_assoc($rowSQL))
                {
                  echo "<option value='".$row['sid']."'>".$row['sid']."-".$row['Name']."</option>";

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
      </form>
    </section>
    <footer>
      <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
      <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>
<!--jini-->
