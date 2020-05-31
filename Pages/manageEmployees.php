<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    if ($_SESSION['DES']!='Manager') {
      header('Location:empHome.php');
    }
    if (!isset($_SESSION['eno2'])) {
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>Manage Employees</title>
    <script type="text/javascript">
      function validateUname()
      {
        var uname=document.getElementById('txtName').value;
        if(/^[a-zA-Z0-9_ ]*$/.test(uname) == false){
          alert("Please enter a valid Username");
          event.preventDefault();
        }
        else{

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
                <!-- <div class="btn-navi"><i class="ion-navicon-round"></i></div> -->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="viewEmployees.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
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
         $st=$row['status'];
         $readonly="";
         if($st=='inactive'){
            $readonly="readonly";
         }
    echo"
          <section class='section-manage'>
          <h2>Manage Employees</h2>
              <form action='../PHPScripts/manageEmployeesScript.php' method='post'>
              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtEno'>Eno</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtEno' id='txtEno' value='" .$row['eno']."' required readonly>
                </div>
              </div>

              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtName'>Name</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtName' id='txtName' value='" .$row['Name']."' required $readonly>
                </div>
              </div>

              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtDes'>Designation</label>
                </div>
                <div class='col span-1-of-2'>";
                if($st=='inactive'){
                  echo"<input type='text' name='txtDes' id='txtDes' value='".$row['Designation']."' required readonly>";
                }else{
                  echo"<input type='text' name='txtDes' id='txtDes' value='".$row['Designation']."' required readonly style='width:260px; margin-right:5px;'>";
                }
                  $desg = $row['Designation'];
                  if(($desg=='Employee') && $st=='active'){
                    echo"<input type = 'submit' name='btnConfirm' id='btnConfirm' value='Promote'>";
                  }
                  else if(($desg=='Manager') && $st=='active'){
                    echo"<input type = 'submit' name='btnDemote' id='btnDemote' value='Demote'>";
                  }
                  echo"
                </div>
              </div>

              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='lstDepartment'>Department</label>
                </div>
                <div class='col span-1-of-2'>";
                echo"
                  <select name='lstDepartment' id='lstDepartment'>
                      <option value='".$row['Dept']."'>
                          ".$row['Dept']."
                      </option>";
                      if($desg!='Manager' && $st=='active'){
                        echo"<option value='store'>
                            Store
                        </option>
                        <option value='pFloor'>
                            Production floor
                        </option>
                        <option value='fGoods'>
                            Finished goods
                        </option>";
                      }
                      echo"
                  </select>
                </div>
              </div>

              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtEmail'>Email</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='email' name='txtEmail' id='txtEmail' value='" .$row['email']. "' required $readonly>
                </div>
              </div>";

              // <div class='row'>
              //   <div class='col span-1-of-2'>
              //     <label for='txtPwd'>Password</label>
              //   </div>
              //   <div class='col span-1-of-2'>
              //     <input type='text' name='txtPwd' id='txtPwd' value=" .$row['password']. " required minlength='5' $readonly>
              //   </div>
              // </div>
              echo"
              <div class='row'>
                <div class='col span-1-of-2'>
                  <label for='txtStatus'>Status</label>
                </div>
                <div class='col span-1-of-2'>
                  <input type='text' name='txtStatus' id='txtStatus' value='".$row['status']."' required readonly >
                </div>
              </div>
              ";
              if($st=='active'){
                echo"
              <div class='row'>
              <div class='col span-1-of-2'></div>
              <div class='col span-1-of-2'><input type='submit' id='btnNext' name='btnNext' value='Update Password'></div>
              </div>";
              }
              echo"
              <div class='row'>
                  <div class='col span-1-of-2'>&nbsp;</div>
                  <div class='col span-1-of-2'>";
                  if($st=='active'){
                    echo"<input type='submit' name='btnUpdate' id='btnUpdate' value='Update' onclick='validateUname()'>";
                  }

                $con3=mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con3){
                  die("Cannot connect to DB server");
                }
                if($st=='active'){
                  echo"
                      <input type='submit' name='btnDelete' id='btnDelete' value='Delete'>
                </div>
              </div>
                    ";
                }
          mysqli_close($con);
          ?>
          </form>
          </section>

     <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>

<!--gima-->
