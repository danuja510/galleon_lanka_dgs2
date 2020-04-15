<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['eno2'])) {
    header('Location:viewEmployees.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>Manage employees</title>

    <script type="text/javascript">
    function validateEmail()
      {
        var em=document.getElementById("txtEmail").value;
        var atposition=em.indexOf("@");
        var dotposition=em.lastIndexOf(".");
        var em1=em.toLowerCase();

        if (atposition<1 || dotposition<atposition+2 || dotposition+2>=em1.length)
          {
          alert("Please enter a valid e-mail address");
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
    <?php
      $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
          {
           die("cannot connect to DB server");
          }
          $eno2=$_SESSION['eno2'];
         $sql="SELECT * FROM `employees` where `eno`='$eno2';";
         $rowSQL= mysqli_query( $con,$sql);
         $row = mysqli_fetch_assoc( $rowSQL);
    echo"

          <section class='section-manage'>
            <div class='row'>
              <div class='col span-2-of-2'>
              <form action=\"manageEmployees.php\" method=\"post\">
              <table>
              <tr>
                <td>
                  <label for='txtEno'>Eno</label>
                </td>
                <td>
                  <input type='text' name='txtEno' id='txtEno' value=" .$row['eno']. " required readonly>
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='txtName'>Name</label>
                </td>
                <td>
                  <input type=\"text\" name=\"txtName\" id=\"txtName\" value=" .$row['Name']. " required>
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='txtDes'>Designation</label>
                </td>
                <td>
                  <input type=\"text\" name=\"txtDes\" id=\"txtDes\" value=" .$row['Designation']. " required readonly>
                </td> 
                <td class='bt'>
                  ";
                  $desg = $row['Designation'];
                  if($desg=='Employee')
                  {
                    echo"
                  <input type = \"submit\" name=\"btnPromote\" value=\"promote\">
                  ";
                  }
                  echo"
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='lstDepartment'>Department</label>
                </td>
                
                <td>
                  <select name=\"lstDepartment\" id=\"lstDepartment\" style=\"width:200px;\">
      
                      <option value=".$row['Dept'].">
                          ".$row['Dept']."
                      </option>
      
                      <option value=\"store\">
                          Store
                      </option>
      
                      <option value=\"pFloor\">
                          Production floor
                      </option>
      
                      <option value=\"fGoods\">
                          Finished goods
                      </option>
      
                  </select>
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='txtEmail'>Email</label>
                </td>
                <td>
                  <input type=\"text\" name=\"txtEmail\" id=\"txtEmail\" value=" .$row['email']. " required>
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='txtPwd'>Password</label>
                </td>
                <td>
                  <input type=\"text\" name=\"txtPwd\" id=\"txtPwd\" value=" .$row['password']. " required>
                </td>
              </tr>
      
              <tr>
                <td>
                  <label for='txtStatus'>Status</label>
                </td>
                <td>
                  <input type=\"text\" name=\"txtStatus\" id=\"txtStatus\" value=" .$row['status']. " required readonly >
                </td>
              </tr>
              </table>
      
              <div class='row'>
              <div class='row'>
                  <div class='col span-1-of-2'>&nbsp;</div>
                  <div class='col span-1-of-2'>
                  <input type=\"submit\" name=\"btnUpdate\" id=\"btnUpdate\" value=\"Update\" onclick='validateEmail()'>
                </td>
                ";
                $st=$row['status'];
                $con3=mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con3){
                  die("Cannot connect to DB server");
                }
      
                echo"
                <tr>
                  <td>
                ";
      
                if($st=='active'){
                  echo"
                      <input type='submit' name='btnDelete' id='btnDelete' value='Delete'>
                      </div>
                    </div>
                </div>
                    ";
                }
      
          mysqli_close($con);
          ?>
      
                      </td>
                  </tr>
                
          </form>
              </div>
            </div>
          </section>

     <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>

     <?php
     if(isset($_POST["btnUpdate"])){
       $name=$_POST["txtName"];
       $dep=$_POST["lstDepartment"];
       $pass=$_POST["txtPwd"];
       $email=$_POST["txtEmail"];
       $con=mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con){
         die("Cannot connect to DB server");
       }

       $sql1="UPDATE `employees` SET `Name` = '".$name."',`Dept`='".$dep."', `password` = '".$pass."',`email` = '".$email."' WHERE `eno` = '".$_SESSION['eno2']."'";
       mysqli_query($con,$sql1);
       mysqli_close($con);
       }
       ?>

     <?php
     if(isset($_POST["btnDelete"])){
       $con=mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con){
         die("Cannot connect to DB server");
       }
       $sql3="UPDATE `employees` SET `status` = 'inactive' WHERE `eno` = '".$_SESSION['eno2']."'";
       mysqli_query($con,$sql3);
       mysqli_close($con);
       //echo "deleted";
       }
        ?>

        <?php

      if(isset($_POST["btnPromote"])){
        //echo "promoted";
        $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con){
          die("Cannot connect to DB server");
        }
        $sql4="UPDATE `employees` SET `Designation` = 'Manager' WHERE `eno` = '".$_SESSION['eno2']."'";
        $sql5="UPDATE `employees` SET `Dept` = 'Manager' WHERE `eno` = '".$_SESSION['eno2']."'";
        mysqli_query($con,$sql4);
        mysqli_query($con,$sql5);
        mysqli_close($con);

        }
        ?>

  </body>
</html>

<!--gima-->
