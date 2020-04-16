<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
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
            <div class="col span-1-of-2">
                <table>
      <thead>
        <th>Finished Product ID</th>
        <th>Finished Product Name</th>
        <th>Qty. to be Inserted</th>
        <th></th>
      </thead>
      <?php
      $query=[];
      $query2=[];
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
                ".$order[0]."
              </td>
              <td>
                ".$row['Name']."
              </td>
              <td>
                ".$order[1]."
              </td>
            </tr>
          ";
            $query[$i]="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$order[0]."', '".$order[1]."', 'finished product', CURDATE(), 'pfloor');";
            $_SESSION['USQ_1']=$query;
        }
      }
      ?>
    </table>
            </div>
            <div class="col span-1-of-2">
                <table>
      <thead>
        <th>Material ID</th>
        <th>Updated Qty.</th>
      </thead>
      <?php
        $ifg_us=$_SESSION['ifg_us'];
        $ifg_uss=explode(',',$ifg_us);
        for ($i=0; $i <sizeof($ifg_uss)-1 ; $i++) {
          $order=explode('x',$ifg_uss[$i]);
          $sql4="SELECT `item_no`,`type`,SUM(qty) as Qty FROM `stocks` WHERE `dept`='pfloor'AND `item_no`=".$order[0]." AND `type`='material' GROUP BY `item_no`,`type`;";
          $rowSQL4= mysqli_query( $con,$sql4);
          $row4 = mysqli_fetch_array( $rowSQL4 );
          echo "
            <tr>
              <td>
                ".$order[0]."
              </td>
              <td>
                ".($row4['Qty']-$order[1])."
              </td>
            </tr>
          ";
          $query2[$i]="INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES (NULL, '".$order[0]."', '".-$order[1]."', 'material', CURDATE(), 'pfloor');";
            $_SESSION['USQ_2']=$query;
          }
        mysqli_close($con);
      ?>
        <tr>
            <td class="bt">&nbsp;</td>
            <td class="bt">
                <form action="../PHPScripts/confirmIFGScript.php" method="post">
                    <input type="submit" class="btn-confirm" id="btnConfirm" name="btnConfirm" value="Confirm">
                </form>
            </td>
        </tr>
    </table>
    
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
