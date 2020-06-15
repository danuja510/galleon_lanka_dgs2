<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }else if (!isset($_SESSION['dept'])) {
    header('Location:createGTN.php');
  }else if (!isset($_SESSION['GTN'])) {
    header('Location:createGTN.php');
  }
  echo $_SESSION['GTN'];
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
    <title>ConfirmGTN</title>
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
                <a href="stocksForGTN.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class="conf-gtn">
      <div class="row">
          <div class="col span-2-of-2">
              <table>
      <thead>
        <th>Item Name</th>
        <th>Item Type</th>
        <th>Qty.</th>
      </thead>
      <?php
        $query=[];
        $GTN=$_SESSION['GTN'];
        $GTN1=explode('+',$GTN);
        $gtnType=$GTN1[0];
        $GTNs=explode(',',$GTN1[1]);
        $count=0;
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
            die("Error while connecting to database");
        }
        $rowSQL = mysqli_query( $con,"SELECT MAX( gtn_no ) AS max FROM `gtn`;" );
        $row = mysqli_fetch_array( $rowSQL );
        $max = $row['max'];
        $gtn_no=$max+1;
        for ($i=0; $i <sizeof($GTNs)-1 ; $i++) {
          $order=explode('x',$GTNs[$i]);
          if ($order[1]==0) {
          }else {
            $count++;
            $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
            {
              die("Error while connecting to database");
            }
            mysqli_close($con);
            echo "
              <tr>
                <td>".$order[0]."</td>
                <td>".$order[2]."</td>
                <td>".$order[1]."</td>
              </tr>
            ";
            $query[$i]="INSERT INTO `gtn` (`no`, `gtn_no`, `item_name`,`item_type`, `qty`, `type`, `remarks`, `dept`,`prepared_by`, `approved_by`, `date`) VALUES (NULL, '".$gtn_no."', '".$order[0]."', '".$order[2]."', '".$order[1]."','".$gtnType."', NULL, '".$_SESSION['dept']."','".$_SESSION['eno']."', NULL, CURDATE());";
          }
        }
        unset($_SESSION['GTN']);
        $_SESSION['gdept']=$_SESSION['dept'];
          unset($_SESSION['dept']);
          $_SESSION['gtype']=$gtnType;
            $_SESSION['GTNQ']=$query;
            $_SESSION['GTNQC']=$count;
            $_SESSION['gtn']=$gtn_no;
      ?>
    </table>
          </div>
      </div>
      <form  action="../PHPScripts/confirmGTNScript.php" method="post">
      <div class="row">
        <div class="col span-1-of-8">
          <label for="txtRemarks">Remarks</label>
        </div>
        <div class="col span-7-of-8">
          <input type="text" name="txtRemarks" id="txtRemarks">
        </div>
      </div>
      <div class="row">
          <input type="submit" name="btnConfirm" value="Confirm" id="btnConfirm">
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
