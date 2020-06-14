<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='store' || $_SESSION['DEPT']=='fGoods') {
    header('Location:empHome.php');
  }else if (!isset($_SESSION['ifg'])) {
    header('Location:inputFinishedGoods.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>confirmIFG</title>
  </head>
  <body>
     <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="inputFinishedGoods.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section>
        <div class="row">
            <div class="col span-2-of-2">
                <table>
      <thead>
        <th>Finished Product Name</th>
        <th>Qty. to be Inserted</th>
        <th></th>
      </thead>
      <?php
      $query=[];
      $ifg=$_SESSION['ifg'];
      $ifgs=explode(',',$ifg);
      $count=0;
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("Error while connecting to database");
      }
      for ($i=0; $i <sizeof($ifgs)-1 ; $i++) {
        $order=explode('x',$ifgs[$i]);
        if ($order[1]==0) {
        }else {
          $count++;
          $sql="SELECT * FROM `finished_products` WHERE `fp_id` = ".$order[0].";";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          echo "
            <tr>
              <td>
                ".$row['Name']."
              </td>
              <td>
                ".$order[1]."
              </td>
            </tr>
          ";
            $query[$i]="INSERT INTO `stocks` (`no`, `item_name`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$row['Name']."', '".$order[1]."', 'finished_product', NOW(), 'pfloor');";
            $_SESSION['USQ_1']=$query;
        }
      }
      ?>
    </table>
  </div>
        <div class="row">
          <div class="col span-3-of-4">
            &nbsp;
          </div>
          <div class="col span-1-of-4">
            <form action="../PHPScripts/confirmIFGScript.php" method="post">
                <input type="submit" class="btn-confirm" id="btnConfirm" name="btnConfirm" value="Confirm">
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
<!--dan-->
