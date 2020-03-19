<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['sid'])) {
    header('Location:createGRN.php');
  }else {
  if (isset($_SESSION['pono'])) {
    $pono=$_SESSION['pono'];
  }
  }
  $sid=$_SESSION['sid'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/CheckboxStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>GRN</title>
  </head>
  <body>
    <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
          <div class="row">
            <div class="btn-navi">
              <i class="ion-navicon-round"></i>
            </div>
            <a href="empHome.php">
              <div class="btn-home">
                <i class="ion-home"></i>
                <p>Home</p>
              </div>
            </a>
            <a href="logout.php">
              <div class="btn-logout">
                <i class="ion-log-out"></i>
                <p>Logout</p>
              </div>
            </a>
            <a href="#">
              <div class="btn-account">
                <i class="ion-ios-person"></i>
                <p>Account</p>
              </div>
            </a>
          </div>
        </div>
    </header>
    <?php
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      echo "<h2>Materials from :".$row['Name']."</h2>";
      mysqli_close($con);
    ?>
    <section class="section-manage">
        <div class="row">
          <form action="materialOFGRN.php" method="post">
            <table>
              <thead>
                <th>Material ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Qty.</th>
                <th class="bt">&nbsp;</th>
              </thead>
              <?php
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $sql1="SELECT * FROM `materials` WHERE `sid` ='".$sid."';";
                $rowSQL1= mysqli_query( $con,$sql1);
                while($row1=mysqli_fetch_assoc( $rowSQL1 )){
                  $val=0;
                  $checked="";
                  if (isset($_SESSION['pono'])) {
                    $sql2="SELECT * FROM `purchase_orders` WHERE `po_no` = ".$pono." AND `mid` = ".$row1['mid'].";";
                    $rowSQL2= mysqli_query( $con,$sql2);
                    if(mysqli_num_rows($rowSQL2)>0){
                    $row2 = mysqli_fetch_array( $rowSQL2 );
                    $val=$row2['qty'];
                    $checked="checked='checked'";
                  }
                }
                echo "<tr><td>".$row1['mid']."</td><td>".$row1['Name']."</td><td>".$row1['Type']."</td><td>".$row1['value']."</td><td><input type='number' id='txt".$row1['mid']."' name='txt".$row1['mid']."' value='".$val."' step='1' min='0'></td><td><input id='".$row1['mid']."' type='checkbox' class='css-checkbox' name='".$row1['mid']."' value='".$row1['mid']."' ".$checked."><label class='css-label' for='".$row1['mid']."'>&nbsp;</label></td></tr>";
                }
                mysqli_close($con);
              ?>
              <tr>
                <td class="bt">&nbsp;</td>
                <td class="bt">&nbsp;</td>
                <td class="bt">&nbsp;</td>
                <td class="bt">&nbsp;</td>
                <td class="bt">&nbsp;</td>
                <td class="bt"><input type="submit" name="btnNext" value="Next"></td>
              </tr>
            </table>
          </form>
        </div>
    </section>
    <footer>
        <div class="row">
                <p>Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
    <?php
      if (isset($_POST['btnNext'])) {
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $rowSQL3= mysqli_query( $con,$sql1);
        $m="";
        $count=0;
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          if(isset($_POST[$row3['mid']])){
            $count++;
            $m=$m.$row3['mid'].'x'.$_POST['txt'.$row3['mid']].',';
          }
        }
        if($count==0){
          echo "<script type='text/javascript'>
            alert('Select A Material to Order');
            event.preventDefault();
          </script>";
        }else {
          $_SESSION['GRN']=$m;
          header('Location:confirmGRN.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
