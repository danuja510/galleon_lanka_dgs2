<?php
 session_start();

 require '../PHPScripts/stock.php';

 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='store'){
    header('Location:empHome.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>createInvoice</title>
    <script type="text/javascript">
    function validateCustomer(){
      var cno=document.getElementById("txtCNO").value;
      if (cno=='__') {
        alert('Please Select A Customer');
        return false;
      }else{
        return true;
      }
    }
    function validate()
    {
      if(validateCustomer())
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
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="manageInvoices.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
      <section class="section-manage">
        <form action="../PHPScripts/createInvoiceScript.php" method="post">
      <div class="row">
        <div class="col span-1-of-7">
            <div class="row nc">
              <label class="dd" for="txtCNO">Select Customer</label>
            </div>
            <div class="row ncr">
              <select name="txtCNO" id="txtCNO">
                  <option value="__">___</option>
                  <?php
                  $sql="SELECT * FROM `customer` where `state` = 'active';";
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $rowSQL= mysqli_query( $con,$sql);
                  while($row=mysqli_fetch_assoc( $rowSQL )){
                    echo "<option value='".$row['cno']."'>".$row['cno']."-".$row['Name']."</option>";
                  }
                  mysqli_close($con);
                  ?>
            </select>
            </div>
            <div class="row ncr">
                If new Customer <a href="addCustomer.php">Click here</a>
            </div>
        </div>
          <div class="col span-6-of-7">
              <table>
              <thead>
          <th>Item Name</th>
          <th>Available Qty.</th>
          <th>Qty. to be Sold</th>
          <th class="bt">&nbsp;</th>
        </thead>
        <?php
        $stockArr= viewStocksEmployee($dept='fGoods');
        foreach ($stockArr as $stock) {
          echo"
                <tr>
                  <td>".$stock->item_name."</td>
                  <td>".$stock->qty."</td>
                  <td><input type='number' id='txt".$stock->item_name."' name='txt".$stock->item_name."' step='1' min='0' max='".$stock->qty."' value='0'></td>
                  <td><input type='checkbox' id='".$stock->item_name."' class='css-checkbox' name='".$stock->item_name."' value='".$stock->item_name."'><label class='css-label' for='".$stock->item_name."'>&nbsp;</label></td>
                </tr>
          ";
        }
        ?>
      <tr><td class="bt">&nbsp;</td><td class="bt">&nbsp;</td><td class="bt">&nbsp;</td><td class="bt chk"><input type="submit" name="btnNext" value="Next" onclick="validate()"></td></tr>
            </table>
          </div>
            </div>
          </form>
      </section>
      <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
      </footer>
      <?php
      if(isset($_GET['count'])){
          if($_GET['count']==0){
              echo "<script type='text/javascript'>alert('Select An Item to be Sold');</script>";
          }
          unset($_GET['count']);
      }
      if(isset($_GET['count2'])){
          if($_GET['count2']==0){
              echo "<script type='text/javascript'>alert('Please add a Quantity for the Respective Item');</script>";
          }
          unset($_GET['count2']);
      }
      ?>
  </body>
</html>
<!--dan-->
