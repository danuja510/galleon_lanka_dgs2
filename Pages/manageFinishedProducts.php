<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['fpid'])) {
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
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
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
      $fp=$_SESSION['fpid'];
       $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_assoc( $rowSQL);

echo"
        <section class='section-manage'>
          <div class='row'>
              <div class='col span-2-of-2'>
              <form action='../PHPScripts/manageFinishedProductsScript.php' method='post'>
              <table>
        
                <tr>
                  <td>
                    <label for='txtFpid'>FP ID</label>
                  </td>
                  <td>
        
                    <input type='text' name='txtFpid' id='txtFpid' value=".$row['fp_id']." style='width:200px;' required readonly>
                  </td>
                </tr>
        
                <tr>
                  <td>
                    <label for='txtName'>Name</label>
                  </td>
                  <td>
                    <input type='text' name='txtName' id='txtName' value=".$row['Name']." style='width:200px;' required>
                  </td>
                </tr>
        ";
        echo "
                <tr>
                  <td>
                    <label for='lstBomid'>BOM ID</label>
                  </td>
                  <td>
                    <select name='lstBomid' id='lstBomid' style='width:200px;'>
        
                        <option value=".$row['bom_id'].">
                           ".$row['bom_id']."
                        </option>
        ";
                        $bom=$row['bom_id'];
                        $sql2="SELECT distinct `bom_id` FROM `bom` where `bom_id` != '$bom' ;";
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
                  </td>
                </tr>
                  ";
                  $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
                  $rowSQL= mysqli_query( $con,$sql);
                  $row = mysqli_fetch_assoc( $rowSQL);
        echo"
                <tr>
                  <td>
                    <label for='txtValue'>value</label>
                  </td>
                  <td>
                    <input type='number' name='txtValue' id='txtValue' value=".$row['value']." min='0' step='0.01' style='width:200px;' required>
                  </td>
                </tr>
        
                <tr>
                  <td>
                    <label for='txtStatus'>status</label>
                  </td>
                  <td>
                    <input type='text' name='txtStatus' id='txtStatus' value=".$row['status']." style='width:200px;' readonly>
                    </td>
                </tr>
        
                <tr>
                  <td>
                      
                  </td>
        
                  <td>
                      <input type='submit' name='btnUpdate' value='update'>
        ";
                  $st=$row['status'];
                  if($st=='active'){
        echo"
                      <input type='submit' name='btnDelete' id='btnDelete' value='delete'>
        ";
                  }
        echo"
                </tr>
        ";
                    ?>
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
