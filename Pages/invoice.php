<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
 ?>
<!DOCTYPE html>
 <html>
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <script type = "text/javascript">

    function validateCustomer()
    {
      var cno=document.getElementbyId("txtcno").value;
      if (cno=="")
      {
          alert('Enter Customer Number');
          return false;
      }
      else {
        return true;
      }
    }

    function validateQuantity()
    {
      var q=document.getElementbyId("txtQuantity").value;
      if (q=="")
        {
          alert("Enter quntity");
          return false;
        }
        else {
          return true;
        }
    }

/*    function Calculatetotal()
    {

        var q=document.getElementById('txtQuantity');
        var p=document.getElementById('txtUnitPrice');

        var total= q*p;

        document.getElementById('txtTotal').value= total;
*/

    function Validate()
    {
        if(validateCustomer()&&validateQuantity())
        {

        }
        else
        {
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
    <h1 align="center">Invoice</h1>
    <section class="section-add">
    <form action="../PHPScripts/invoiceScript.php" method= "post">

      <div class="row">
                  <div class="col span-1-of-2">
                      <label for="lstCustomer">Select Customer</label>
                  </div>
                  <div class="col span-1-of-2">
                      <select name="lstCustomer" id="lstCustomer">
                        <option value='__'>___</option>
                        <?php
                          $sql="SELECT * FROM `customer`;";
                          $con = mysqli_connect("localhost","root","","galleon_lanka");
                          if(!$con)
                          {
                            die("Error while connecting to database");
                          }
                          $rowSQL= mysqli_query( $con,$sql);
                                  while($row=mysqli_fetch_assoc( $rowSQL )){
                            echo "
                              <option value='".$row['cno']."'>".$row['Name']."</option>
                            ";
                          }
                          mysqli_close($con);
                          ?>
                      </select>
                  </div>
              </div>


          <div class="row">
            <div class="col span-1-of-2">
              <label for= "txtItemNo">Item No</label>
            </div>
              <div class="col span-1-of-2">
                  <input type="text" name="txtItemNo" id="txtItemNo" value="">
              </div>
          </div>
          <div class="row">
              <div class="col span-1-of-2">
                  <label for="txtQuantity">Quantity</label>
              </div>
              <div class="col span-1-of-2">
                  <input type="number" name="txtQuantity" id="txtQuantity" value="">
              </div>
            </div>
            <div class="row">
              <div class="col span-1-of-2">
                  <label for="txtUnitPrice">Unit Price</label>
              </div>
              <div class="col span-1-of-2">
                  <input type="number" name="txtUnitPrice" id="txtUnitPrice" value="">
              </div>
            </div>
            <div class="row">
              <div class="col span-1-of-2">
                  <label>Prepared by</label></td>
              </div>
              <div class="col span-1-of-2">
                    <input type="text" name="txtPreparedBy" id="txtPreparedBy" value=""></td>
              </div>
            </div>

          <div class="row">
            <div class="col span-1-of-2">
                <label>Vehicle Number</label>
            </div>
            <div class="col span-1-of-2">
                <input type="text" name="txtVehicleNo" id="txtVehicleNo" value="">
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              &nbsp;
            </div>
          <div class="col span-1-of-2">
              <input type="Submit" name="btnSubmit" id="btnSubmit" value="Create Invoice" onclick="Validate()">
              <input type="Reset" name="btnReset" id="btnReset" value="Reset">
            </tr>
          </div>
         </div>

         <div class="row">
           <div class="col span-1-of-2">
              <label for="txtTotal">Sub Total</label>
            </div>
            <div class="col span-1-of-2">
              <input type="text" name="lblTotal" id="lblTotal" value="">
            </div>
          </div>
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
<!--jini-->
