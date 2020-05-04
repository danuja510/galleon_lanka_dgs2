<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    if(!isset($_SESSION['CR'])){
      header('Location:viewcashreceipt.php');
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
        <title>Manage Cash Receipt</title>
        <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
        <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
        <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
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
      <section class="section-view">
      <form action="../PHPScripts/manageCashreceiptScript.php" method="post">
      <div class="row">
          <div class="col span-1-of-2">
          <?php
          $CR=$_SESSION['CR'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT *,sum(amout) as price FROM `cash_receipts` where `cr_no`=".$CR." GROUP BY `cr_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_array( $rowSQL );
          echo "<div class='row'><div class='col span-1-of-2'>Cash Receipt No.</div><div class='col span-1-of-2'> ".$row['cr_no']."</div></div>";
          echo "<div class='row'><div class='col span-1-of-2'>Invoice No.</div><div class='col span-1-of-2'> ".$row['invoice_no']."</div></div>";
          echo "<div class='row'><div class='col span-1-of-2'>Customer No.</div><div class='col span-1-of-2'>".$row['cno'] ."</div></div>";
          $cno=$row['cno'];
          echo "<div class='row'><div class='col span-1-of-2'>Remarks</div><div class='col span-1-of-2'>".$row['remarks'] ."</div></div>";
          echo "<div class='row'><div class='col span-1-of-2'>Amount Rs. </div><div class='col span-1-of-2'> ".$row['price']."</div></div>";
          echo "<div class='row'><div class='col span-1-of-2'>Date</div><div class='col span-1-of-2'>".$row['date'] ."</div></div>";
          echo "<div class='row'><div class='col span-1-of-2'>Prepared by</div><div class='col span-1-of-2'> ".$row['prepared_by']."</div></div>";

          if($row['approved_by']!=null){
            echo"<div class='row'><div class='col span-1-of-2'>Status : </div><div class='col span-1-of-2'> Approved</div></div>";}
          else{
            echo"<div class='row'><div class='col span-1-of-2'>Status : </div><div class='col span-1-of-2'> Pending</div></div>";}
          $value=$row['amout'];

      echo "
        </div>
          <div class='col span-1-of-2'>
          <table>
            <thead>
                <th>
                  Invoice No.
                </th>
                <th>
                  Customer ID.
                </th>
                <th>
                  Amount
                </th>
              </thead>
      ";
          $sql="SELECT * FROM `cash_receipts` WHERE `cr_no`=".$CR.";";
          $rowSQL=mysqli_query($con,$sql);
          while($row1=mysqli_fetch_array($rowSQL))
          {
            echo "
              <tr>
                <td>
                  ".$row1['invoice_no']."
                </td>
                <td>
                  ".$row1['cno']."
                </td>
                <td>
                  ".$row1['amout']."
                </td>
              </tr>
            ";
          }
  echo"
        </table>
        </div>
        </div>

        <div class='row'>
        <div class='row'>
          <div class='col span-1-of-2'>&nbsp;</div>
          <div class='col span-1-of-2'>";
        if($row['approved_by']!=null){
        echo"<input type='submit' value='Print' name='btnPrint'>";
        }else{
        echo"<input type='submit' value='Approve' name='btnConfirm' id='btnConfirm'>";
        }
        echo"<input type='submit' value='Delete' name='btnDelete' id='btnDelete'>
        </div>

        </div>
      </div>";
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
