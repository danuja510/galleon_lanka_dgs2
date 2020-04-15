<?php
session_start();
if(!isset($_SESSION['eno'])){
  header('Location:signIn.php');
}
 ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Add employee</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">

    <script type="text/javascript">
    function validatePassword()
      {
      var pwd=document.getElementById('txtPwd').value;
      var cpwd=document.getElementById('txtconPwd').value;
      if((pwd.length < 3) || (pwd != cpwd))
        {
						alert("Please enter a correct Password and Confirm password");
						return false;
				}else{
        return true;
      }
      }
    function validateDepartment()
      {
        if(document.getElementById('lstDepartment').value == "----------")
          {
            alert("Please select a Department");
						return false;
          }
          else
          {
        return true;
          }
      }
      function validateEmail()
        {
          var em=document.getElementById("txtEmail").value;
          var atposition=em.indexOf("@");
          var dotposition=em.lastIndexOf(".");
          //var em1=em.toLowerCase();

          if (atposition<1 || dotposition<atposition+2 || dotposition+2>=em.length)
            {
              alert("Please enter a valid e-mail address");
              return false;
            }
            else
            {
              return true;
            }
        }
    function Validate()
		  {
					if(validatePassword() && validateDepartment() && validateEmail())
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

    <section>
        <div class="row">
            <div class="col span-2-of-2">
        <form  action="../PHPScripts/addEmployeeScript.php" method="post" >
        <table>
          <tr>
            <td>
              <label for='txtName'>
                Name
              </label>
            </td>
            <td>
              <input type="text" name="txtName" id="txtName" value="" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='lstDepartment'>
                Department
              </label>
            </td>
            <td>
               <select name="lstDepartment" id="lstDepartment" style='width:200px;'>
               <option value="----------">----------</option>
               <option value="store">Store</option>
               <option value="pFloor">Production floor</option>
               <option value="fGoods">Finished goods</option>
               </select>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtEmail'>
                Email
              </label>
            </td>
            <td>
              <input type="email" name="txtEmail" id="txtEmail" value="" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtPwd'>
                Password
              </label>
            </td>
            <td>
              <input type="password" name="txtPwd" id="txtPwd" value="" required>
            </td>
          </tr>

          <tr>
            <td>
              <label for='txtconPwd'>
                Confirm password
              </label>
            </td>
            <td>
              <input type="password" name="txtconPwd" id="txtconPwd" value="" required>
            </td>
          </tr>
          <tr>
            <td>
              
            </td>
            <td>
              <input type="submit" name="btnSubmit" id="btnSubmit" onclick="Validate()">
              <!-- <input type="reset" name="btnReset" id="btnReset"> -->
            </td>
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

<!--gima-->
