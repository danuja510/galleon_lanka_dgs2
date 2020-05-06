<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
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
        <title>User Profile</title>
        <script type="text/javascript">
        function validateUname()
        {
          var uname=document.getElementById('txtName').value;
          if(/^[a-zA-Z0-9]*$/.test(uname) == false){
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
        $eno=$_SESSION['eno'];
        $sql="SELECT * FROM `employees` where `eno`='$eno';";
        $rowSQL= mysqli_query( $con,$sql);
        $row = mysqli_fetch_assoc( $rowSQL);
        mysqli_close($con);

        echo"
            <section class='section-manage'>

            <h2> ".$row['Name']." </h2>
                <form action='../PHPScripts/userProfileScript.php' method='post'>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtEno'>Eno</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='text' name='txtEno' id='txtEno' value=".$row['eno']." required readonly>
                  </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtName'>Name</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='text' name='txtName' id='txtName' value=".$row['Name']." required>
                  </div>
                </div>

                <div class='row'>
                    <div class='col span-1-of-2'>
                        <label>Department</label>
                    </div>
                    <div class='col span-1-of-2'>
                        <p>".$row['Dept']."</p>
                    </div>
                </div>

                <div class='row'>
                    <div class='col span-1-of-2'>
                      <label for='txtEmail'>Email</label>
                    </div>
                    <div class='col span-1-of-2'>
                      <input type='email' name='txtEmail' id='txtEmail' value=".$row['email']."  required>
                    </div>
                </div>

                <div class='row'>
                    <div class='col span-1-of-2'>
                      <label for='txtPwd'>Password</label>
                    </div>
                    <div class='col span-1-of-2'>
                      <input type='submit' id='btnNext' name='btnNext' value='Update Password'>
                    </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>&nbsp;</div>
                  <div class='col span-1-of-2'>
                    <input type='submit' name='btnUpdate' id='btnUpdate' value='Update' onclick='validateUname()'>
                  </div>
                </div>

                ";
            ?>
            </div>
            </form>
            </div>
            </section>

          <footer>
            <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
            <div class="row"><p>Designed and Developed by DGS2</p></div>
        </footer>
    </body>
</html>
<!--gima-->
