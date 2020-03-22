<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<!DOCTYPE html>
<html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>AddCustomer</title>
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
    <h2>Add Customer</h2>
    <section class="section-add">
        <form action='addCustomer' method='post'>
            <div class="row">
                <div class="col span-1-of-2">
                    <label for='txtName'>Name</label>
                </div>
                <div class="col span-1-of-2">
                    <input type='text' name='txtName' id='txtName' required>
                </div>
            </div>
            <div class="row">
                <div class="col span-1-of-2">
                    <label for='txtAddress'>Address</label>
                </div>
                <div class="col span-1-of-2">
                    <input type='text' name='txtAddress' id='txtAddress'>
                </div>
            </div>
            <div class="row">
                <div class="col span-1-of-2">
                    <label for='txtTPNo'>TP No</label>
                </div>
                <div class="col span-1-of-2">
                    <input type='text' name='txtTPNo' id='txtTPNo'>
                </div>
            </div>
            <div class="row">
                <div class="col span-1-of-2">
                    <label for='txtType'>Type</label>
                </div>
                <div class="col span-1-of-2">
                    <select name='txtType' id='txtType'>
                      <option value="other">Other</option>
                      <option value="distributor">Distributor</option>
                      <option value="dealer">Dealer</option>
                      <option value="customer">Customer</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col span-1-of-2">
                    &nbsp;
                </div>
                <div class="col span-1-of-2">
                    <input type="submit" name="btnConfirm" id="btnConfirm" value="Submit">
            <input type="reset" name="btnReset" id="btnReset" value="Reset">
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
    <?php
		if(isset($_POST["btnConfirm"])){
			$name=$_POST["txtName"];
            $address=$_POST["txtAddress"];
            $type=$_POST["txtType"];
            $tpNo=$_POST["txtTPNo"];
            $con=mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con){
				die("Cannot connect to DB server");
			}
			$sql="INSERT INTO `customer` (`cno`, `Name`, `Address`, `tpno`, `type`) VALUES (NULL, '".$name."', '".$address."', '".$tpNo."', '".$type."');";
			mysqli_query($con,$sql);
			mysqli_close($con);
            header('Location:empHome.php');
        }
	?>
  </body>
</html>
<!--dan-->
