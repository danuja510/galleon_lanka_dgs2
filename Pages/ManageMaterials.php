<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['mid'])) {
    header('Location:viewMaterials.php');
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage Materials</title>
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
      $material=$_SESSION['mid'];
       $sql="SELECT * FROM `materials` where `mid`='$material';";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_assoc( $rowSQL);
       $t=$row['Type'];

echo"
  <section class='section-manage'>
    <h2>Manage Materials</h2>
    <form action='../PHPScripts/manageMaterialsScript.php' method='post'>

        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='txtMid'>M_ID</label>
          </div>
          <div class='col span-1-of-2'>

            <input type='text' name='txtMid' id='txtMid' value=" .$row['mid']. " required readonly>
          </div>
        </div>

        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='txtName'>Name</label>
          </div>
          <div class='col span-1-of-2'>
            <input type='text' name='txtName' id='txtName' value=" .$row['Name']. " required>
          </div>
        </div>


        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='lstSupplier'>Supplier</label>
          </div>
          <div class='col span-1-of-2'>
            <select name='lstSupplier' id='lstSupplier'>

                <option value=".$row['sid'].">
                   ".$row['sid']."
                </option>
";
                $sid=$row['sid'];
                $sql2="SELECT distinct `sid`, `Name` FROM `supplier` where `sid` != '$sid' ;";
                $rowSQL= mysqli_query( $con,$sql2);

                while($row = mysqli_fetch_assoc( $rowSQL)){
echo"
                <option value='".$row['sid']."'>
                   ".$row['sid']."
                </option>
";
              }
echo "
            </select>
          </div>
        </div>

        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='lstType'>Type</label>
          </div>
          <div class='col span-1-of-2'>
            <select name='lstType' id='lstType'>

                <option value=".$t.">
                   ".$t."
                </option>
";
                $type=$row['Type'];
                $sql2="SELECT distinct `type` FROM `materials` where `type` != '$t' ;";
                $rowSQL= mysqli_query( $con,$sql2);
                $row = mysqli_fetch_assoc( $rowSQL);
echo"
                <option value='Packing'>
                   Packing
                </option>
                <option value='Raw'>
                   Raw
                </option>
                <option value='Chemical'>
                   Chemical
                </option>
            </select>
          </div>
        </div>
          ";

          $sql="SELECT * FROM `materials` where `mid`='$material';";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_assoc( $rowSQL);
          mysqli_close($con);
echo"
        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='txtValue'>value</label>
          </div>
          <div class='col span-1-of-2'>
            <input type='number' name='txtValue' id='txtValue' value=".$row['value']." min='0' step='0.01' required>
          </div>
        </div>

        <div class='row'>
          <div class='col span-1-of-2'>
            <label for='txtStatus'>status</label>
          </div>
          <div class='col span-1-of-2'>
            <input type='text' name='txtStatus' id='txtStatus' value='" .$row['status']."' readonly>
            </div>
        </div>

        <div class='row'>
        <div class='col span-1-of-2'>
        </div>
          <div class='col span-1-of-2'>
              <input type='submit' name='btnUpdate' value='Update'>
              <input type='submit' name='btnDelete' id='btnDelete' value='Delete'>
          </div>

          <div>
";
        $st=$row['status'];
        if($st=='active'){
echo"

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
<!--sithara-->
