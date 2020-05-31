<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    if ($_SESSION['DEPT']=='store'){
      header('Location:empHome.php');
    }
    if (!isset($_SESSION['fpid'])) {
    header('Location:viewFinishedProducts.php');
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage Finished Products</title>
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
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
                <a href="viewFinishedProducts.php">
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
      $fp=$_SESSION['fpid'];
       $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_assoc( $rowSQL);
       $st=$row['status'];
         $readonly="";
         $disabled="";
         if($st=='inactive'){
            $readonly="readonly";
            $disabled="disabled";
         }

echo"
        <section class='section-manage'>
        <h2>Manage Finished Products</h2>
              <form action='../PHPScripts/manageFinishedProductsScript.php' method='post'>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtFpid'>FP ID</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='text' name='txtFpid' id='txtFpid' value='".$row['fp_id']."' required readonly>
                  </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtName'>Name</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='text' name='txtName' id='txtName' value='".$row['Name']."' required $readonly>
                  </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='lstBomid'>BOM ID</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <select name='lstBomid' id='lstBomid' $disabled>

                        <option value='".$row['bom_id']."'>
                           ".$row['bom_id']."
                        </option>
        ";
                        $bom=$row['bom_id'];
                        $sql2="SELECT distinct `bom_id` FROM `bom` where `bom_id` != '$bom' and `state`='active' ;";
                        $rowSQL= mysqli_query( $con,$sql2);
                        while($row = mysqli_fetch_assoc( $rowSQL)){
        echo"
                        <option value='".$row['bom_id']."'>
                           ".$row['bom_id']."
                        </option>
        ";
                      }
        echo "
                    </select>
                  </div>
                </div>
                  ";
                  $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
                  $rowSQL= mysqli_query( $con,$sql);
                  $row = mysqli_fetch_assoc( $rowSQL);
        echo"
                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtValue'>Value</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='number' name='txtValue' id='txtValue' value='".$row['value']."' min='0' step='0.01' required $readonly>
                  </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>
                    <label for='txtStatus'>Status</label>
                  </div>
                  <div class='col span-1-of-2'>
                    <input type='text' name='txtStatus' id='txtStatus' value='".$row['status']."' readonly>
                    </div>
                </div>

                <div class='row'>
                  <div class='col span-1-of-2'>
                     &nbsp;
                  </div>
                  <div class='col span-1-of-2'>";
                  if($st=='active'){
                      echo"<input type='submit' name='btnUpdate' value='Update'>";
                  }
                  $st=$row['status'];
                  if($st=='active'){
        echo"
                      <input type='submit' name='btnDelete' id='btnDelete' value='Delete'>
                  </div>
        ";
                  }
        echo"
                </div>
        ";
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
