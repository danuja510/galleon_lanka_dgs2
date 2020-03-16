<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>signIn</title>
    <script type="text/javascript">
    function validateEmpNo()
    {
      var eno= document.getElementById("txtENO").value;
       if (isNaN(eno)) {
        alert("Enter A Valid Employee Number");
        return false;
      }
      else
        return true;
    }

    /*function validatePassword()
    {
      var pwd=document.getElementById("txtPass").value;
      if(pwd=="")
      {
        alert("Enter the password");
        return false;
      }
      else
        return true;
    }*/

    function validate()
    {
      if(validateEmpNo() /*&& validatePassword()*/)
        {}
      else
        event.preventDefault();
    }
    </script>
  </head>
  <body>
    <h1>Sign In</h1>
    <form action="signIn.php" method="post">
      <table>
        <tr>
          <td>
            <label for="txtENO">Employee No</label>
          </td>
          <td>
            <input type="text" name="txtENO" id="txtENO" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="txtPass">Password</label>
          </td>
          <td>
            <input type="password" name="txtPass" id="txtPass" required>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" name="btnsubmit" id="btnsubmit" value="Submit" onclick="validate()">
            <input type="reset" value="Reset" name="btnreset>"
          </td>
        </tr>
      </table>
    </form>
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
