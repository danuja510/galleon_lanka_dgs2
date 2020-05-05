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
    <title>Add employee</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">

    <script type="text/javascript">
    function validatePassword()
      {
      var pwd=document.getElementById('txtPwd').value;
      var cpwd=document.getElementById('txtconPwd').value;
      if(pwd != cpwd)
        {
						alert("Passwords do not match");
						return false;
				}else{
        return true;
      }
      }
    function validateDepartment()
      {
        if(document.getElementById('lstDepartment').value == "----------"){
            alert("Please select a Department");
						return false;
          }
          else{
            return true;
          }
      }
    function validateUname()
      {
        var uname=document.getElementById('txtName').value;
        if(/^[a-zA-Z0-9]*$/.test(uname) == false){
          alert("Please enter a valid Username");
          return false;
        }
        else{
          return true;
        }
      }
    function Validate()
		  {
					if(validatePassword() && validateDepartment() && validateUname()){
					}
					else{
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

    <h2>Add Employee</h2>
    <section class="section-add">
    <form  action="../PHPScripts/addEmployeeScript.php" method="post" >
        <div class="row">
            <div class="col span-1-of-2">
              <label for='txtName'>
                Name
              </label>
            </div>
            <div class="col span-1-of-2">
              <input type="text" name="txtName" id="txtName" required>
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              <label for='lstDepartment'>
                Department
              </label>
            </div>
            <div class="col span-1-of-2">
               <select name="lstDepartment" id="lstDepartment" >
               <option value="----------">----------</option>
               <option value="store">Store</option>
               <option value="pFloor">Production floor</option>
               <option value="fGoods">Finished goods</option>
               </select>
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              <label for='txtEmail'>
                Email
              </label>
            </div>
            <div class="col span-1-of-2">
              <input type="email" name="txtEmail" id="txtEmail" value="" required>
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              <label for='txtPwd'>
                Password
              </label>
            </div>
            <div class="col span-1-of-2">
              <input type="password" name="txtPwd" id="txtPwd" value="" minlength='5' required>
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              <label for='txtconPwd'>
                Confirm password
              </label>
            </div>
            <div class="col span-1-of-2">
              <input type="password" name="txtconPwd" id="txtconPwd" value="" minlength='5' required>
            </div>
          </div>

          <div class="row">
            <div class="col span-1-of-2">
              &nbsp;
            </div>
            <div class="col span-1-of-2">
              <input type="submit" name="btnSubmit" id="btnSubmit" onclick="Validate()">
              <input type="reset" name="btnReset" id="btnReset">
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

<!--gima-->
