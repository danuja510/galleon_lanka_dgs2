<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }else if (!isset($_SESSION['sid'])) {
    header('Location:createGRN.php');
  }else if (!isset($_SESSION['GRN'])) {
    header('Location:createGRN.php');
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/remarksStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>ConfirmGRN</title>
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
                <a href="materialOFGRN.php">
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
        die("Error while connecting to database");
      }
      $sql="SELECT * FROM `supplier` WHERE `sid` = ".$sid.";";
      $rowSQL= mysqli_query( $con,$sql);
      $row = mysqli_fetch_array( $rowSQL );
      echo "<h2>Materials from :".$row['Name']."</h2>";
      mysqli_close($con);
    ?>
    <section>
      <div class="row">
          <div class="col span-2-of-2">
        <table>
        <thead>
          <th>
            Material No.
          </th>
          <th>
            Material Name
          </th>
          <th>
            Material Type
          </th>
          <th>
            Unit Price
          </th>
          <th>
            Qty.
          </th>
          <th>
            Amount
          </th>
        </thead>
        <?php
          $pono="NULL";
          if (isset($_SESSION['pono'])) {
            $pono=$_SESSION['pono'];
          }
          $query=[];
          $GRN=$_SESSION['GRN'];
          $GRNs=explode(',',$GRN);
          $count=0;
          $con = mysqli_connect("localhost","root","","galleon_lanka");
      		if(!$con)
      		{
      			die("Error while connecting to database");
      		}
      		$rowSQL = mysqli_query( $con,"SELECT MAX( grn_no ) AS max FROM `grn`;" );
      		$row = mysqli_fetch_array( $rowSQL );
      		$max = $row['max'];
      		$grn_no=$max+1;
            for ($i=0; $i <sizeof($GRNs)-1 ; $i++) {
              $order=explode('x',$GRNs[$i]);
              if ($order[1]==0) {
              }else {
              $count++;
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `materials` WHERE `mid` = ".$order[0].";";
              $rowSQL= mysqli_query( $con,$sql);
              $row = mysqli_fetch_array( $rowSQL );
              mysqli_close($con);
              echo "<tr><td>".$order[0]."</td><td>".$row['Name']."</td><td>".$row['Type']."</td><td>".$row['value']."</td><td>".$order[1]."</td><td>".$row['value']*$order[1]."</td></tr>";
              $query[$i]="INSERT INTO `grn` (`no`, `grn_no`, `po_no`, `sid`, `mid`, `qty`, `date`, `amount`, `prepared_by_(eno)`,       `remarks`,`approvedBy`)VALUES(NULL,'".$grn_no."',".$pono.",'".$_SESSION['sid']."','".$order[0]."','".$order[1]."',CURDATE(),'".$row['value']*$order[1]."', '".$_SESSION['eno']."', NULL, NULL);";
            }
          }
          unset($_SESSION['GRN']);
          unset($_SESSION['sid']);
          $_SESSION['gsid']=$sid;
            $_SESSION['GRNQ']=$query;
            $_SESSION['GRNQC']=$count;
            $_SESSION['grn']=$grn_no;
        ?>
      </table>
      </div>
      </div>
      <form  action="../PHPScripts/confirmGRNScript.php" method="post">
      <div class="row">
        <div class="col span-1-of-8">
          <label for="txtRemarks">Remarks</label>
        </div>
        <div class="col span-7-of-8">
          <input type="text" name="txtRemarks" id="txtRemarks">
        </div>
      </div>
      <div class="row">
          <input type="submit" class="btn-confirm" name="btnConfirm" value="Confirm" id="btnConfirm">
      </div>
      </form>
    </section>
    <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
  </body>
</html>
<!--dan-->
