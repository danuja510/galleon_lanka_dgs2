<?php
session_start();
if(!isset($_SESSION['eno']))
{
  header('Location:signIn.php');
}
else if(!isset($_SESSION['DES']))
{
  header('Location:signIn.php');
}
else if(!isset($_SESSION['DEPT']))
{
  header('Location:signIn.php');
}
$des=$_SESSION['DES'];
$dep=$_SESSION['DEPT'];

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>view stocks</title>
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
      <section class="section-manage">
        <div class="row">
            <form action="viewStocks.php" method="post">
            <div class="col span-1-of-3">
                    <div class="new">
                    Your Department:
                    <?php
                    echo "$dep";
                    ?>
              <br>
                <?php
                if($dep=="Manager")
                {
            echo"
                    Sort by Department:
                <select name='lstDepartment'>
                  <option value='A'>All</option>
                  <option value='B'>store</option>
                  <option value='C'>P floor</option>
                  <option value='D'>F goods</option>
                </select>
                <input type='submit' name='btnSort' value='Sort'>
            ";
                }
                 ?>
                    </div>
        </div> 
            <div class="col span-2-of-2">    
        <table>
          <thead>
            <td>Department</td>
            <td>item no</td>
            <td>type</td>
            <td>qty</td>
          </thead>

          <?php
          $con=mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
            {
              die("cannot connect to DB server");
            }
            $s="";
            if(isset($_POST['btnSort']))
            {
                $s=$_POST['lstDepartment'];
            }
          if($dep=="Manager")
          {
          $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` GROUP BY dept,item_no;";
          }

          if($dep=="store" || $s=="B")
          {
          $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='store' GROUP BY dept,item_no;";
          }

          if($dep=="pFloor" || $s=="C")
          {
          $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='pfloor' GROUP BY dept,item_no;";
          }

          if($dep=="fGoods" || $s=="D")
          {
          $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='fGoods' GROUP BY dept,item_no;";
          }
          $rowSQL= mysqli_query($con,$sql);
          while($row=mysqli_fetch_assoc($rowSQL))
          {
    echo"
          <tr>
            <td>".$row['dept']."</td>
            <td>".$row['item_no']."</td>
            <td>".$row['type']."</td>
            <td>".$row['finalstock']."</td>
          </tr>
    ";
          }
        ?>

        </table>
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
