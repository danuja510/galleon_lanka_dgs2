<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<html>
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
    <title>add materials</title>

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
    function Validate(){
        if(validateSupplier() &&validateType()){
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
              <div class="btn-navi"><i class="ion-navicon-round"></i></div>
              <a href="empHome.php">
                  <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
              </a>
              <a href="logout.php">
                  <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
              </a>
              <a href="#"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
          </div>
      </div>
  </header>
  <section class="section-manage">
    <div class="row">
      <div class="col span-2-of-2">
        <form action="../PHPScripts/addMaterialsScript.php" method="post">
          <table border="0" align="center">
              <tr>
              <td><label for="txtName">Name</label></td>
              <td><input type="text" name="txtName" id="txtName" value="" required></td>
            </tr>
            <tr>
              <td><label for="lstType">Type</label></td>
              <td>
                <select name="lstType" id="lstType">
                <option value="----------">----------</option>
                <option value="Raw">Raw</option>
                <option value="Packing">Packing</option>
                <option value="Chemical">Chemical</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><label for="lstSid">Supplier</label></td>
              <td>
                <select name="lstSid" id="lstSid">
                <option value='-----'>-----</option>
                <?php
                  $sql="SELECT * FROM `supplier`;";
                  $con = mysqli_connect("localhost","root","","galleon_lanka");
                  if(!$con)
                  {
                    die("Error while connecting to database");
                  }
                  $rowSQL= mysqli_query( $con,$sql);
                  while($row=mysqli_fetch_assoc( $rowSQL )){
                    echo "
                      <option value='".$row['sid']."'> ".$row['Name']." </option>";
                  }
                  mysqli_close($con);
                 ?>
              </select>

              </td>
            </tr>
            <tr>
              <td><label for="txtValue">value</label></td>
              <td><input type="number" name="txtValue" id="txtValue" value="" min="0" step="0.01" required></td>
            </tr>
            <tr>
              <td><input type="Submit" name="btnSubmit" id="btnSubmit" value="Submit" onclick="Validate()"></td>
              <td><input type="Reset" name="btnReset" id="btnReset" value="Reset"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </section>

    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>

  </body>
</html>
<!--sithara--->
