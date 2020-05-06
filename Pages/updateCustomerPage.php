<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
  if(!isset($_SESSION['customer']))
  {
    header('Location:../Pages/ViewCustomer.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">

    <title>Update Customer</title>
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
    <section class ="section-manage">
      <div class ="row">
        <div class = "col span-2-of-2">
          <form action="../PHPScripts/updateCustomerPageScript.php" method="post">
            <?php
              $cno=$_SESSION['customer'];
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `customer` WHERE `cno`=".$cno.";";
              $rowSQL= mysqli_query( $con,$sql);
            	$row = mysqli_fetch_array( $rowSQL );

              echo "<h4>Customer Number: ".$row['cno']."</h4>";

              mysqli_close($con);
             ?>

           <table>
              <tr>
                <td>
                  <label for='txtName'>Name</label>
                </td>
                <td>
                  <input type='text' name='txtName' <?php echo "value='".$row['Name']."'"; ?> id='txtName' required>
                </td>
              </tr>
              <tr>
                <td>
                  <label for='txtAddress'>Address</label>
                </td>
                <td>
                  <input type='text' name='txtAddress' <?php echo "value='".$row['Address']."'"; ?> id='txtAddress' required>
                </td>
              </tr>
              <tr>
                <td>
                  <label for='txtTPNo'>TP No</label>
                </td>
                <td>
                  <input type='text' name='txtTPNo' <?php echo "value='".$row['tpno']."'"; ?> id='txtTPNo' required>
                </td>
              </tr>
              <tr>
                <td>
                  <label for='txtType'>Type</label>
                </td>
                <td>
                  <select name='txtType'  id='txtType'>
                    <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                    <option value="other">Other</option>
                    <option value="distributor">Distributor</option>
                    <option value="dealer">Dealer</option>
                    <option value="customer">Customer</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td class ="bt"></td>
                <td class="bt">
                  <input type="submit" name="btnsubmit" id="btnsubmit" value ="Submit">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
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

 <!--jini-->
