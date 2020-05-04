<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/SignInStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>signIn</title>
  </head>
  <body>
    <header>
      <div class="row">
        <h1>Manufacturing Management System</h1>
        <h3>Galleon Lanka PLC</h3>
      </div>
    </header>
    <section class="section-signIn">
      <h2>Sign In</h2>
      <form action="signIn.php" method="post">
        <div class="row">
          <div class="col span-1-of-2">
            <label for="txtENO">Employee No</label>
          </div>
          <div class="col span-1-of-2">
            <input type="number" name="txtENO" id="txtENO" required>
          </div>
        </div>
        <div class="row">
          <div class="col span-1-of-2">
            <label for="txtPass">Password</label>
          </div>
          <div class="col span-1-of-2">
            <input type="password" name="txtPass" id="txtPass" required>
          </div>
        </div>
        <div class="row">
          <div class="col span-1-of-2">
            <label>&nbsp;</label>
          </div>
          <div class="col span-1-of-2">
            <input type="submit" name="btnsubmit" id="btnsubmit" value="Sign In">
          </div>
        </div>
        <div class="row">
          <div class="col span-1-of-2">
            <label>&nbsp;</label>
          </div>
          <div class="col span-1-of-2">
            <p>If Forgot Password <a href="#">Click here</a><br> If Forgot Employee No. <a href="#">Click here</a></p>
          </div>
        </div>
      </form>
    </section>
    <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
    <?php
    	if(isset($_POST['btnsubmit'])){
    		$eno=$_POST['txtENO'];
    		$pass=$_POST['txtPass'];
    		$sql="SELECT * FROM `employees` WHERE `eno` = ".$eno." AND `password` LIKE '".$pass."';";
    		$con = mysqli_connect("localhost","root","","galleon_lanka");
    			if(!$con)
    			{
    				die("Error while connecting to database");
    			}
    			$result= mysqli_query($con,$sql);

      	if(mysqli_num_rows($result)>0){
          $row=mysqli_fetch_array($result);

          if ($row[ 'Designation']=='Manager') {
            $_SESSION['DES']='Manager';
            $_SESSION['DEPT']='Manager';
          }else {
            if ($row[ 'Designation']=='Employee') {
              $_SESSION['DES']='Employee';
              $_SESSION['DEPT']=$row[ 'Dept'];
            }
          }
      		$_SESSION['eno']=$eno;
      		header('Location:empHome.php');
    		}else{
    			echo "invalid credentials";
        }
    	}
    ?>
  </body>
</html>
<!--dan-->
