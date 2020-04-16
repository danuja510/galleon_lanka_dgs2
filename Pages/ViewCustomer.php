<?php
  session_start();
  if(!isset($_SESSION['eno']))
  {
    header('Location:signIn.php');
  }
 ?>
 <html>
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
   <title>View Customer</title>
  <head>
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
    <section class = "section-manage">
      <div class = "row">
        <div class ="col span-1-of-2">
          <a href="addCustomer.php">
            <div class="new">
              <i class="ion-ios-compose-outline"></i>
              New Customer
            </div>
          </a>
        </div>
        <div class="col span-6-of-7">
          <form action="../PHPScripts/ViewCustomerScript.php" method="post">
            <table>
              <thread><th>Customer Number</th><th> Name </th><th> Address </th><th> Telephone No. </th><th> Customer Type </th><th class="bt">&nbsp;</th></thead>
              <?php
              $con = mysqli_connect("localhost","root","","galleon_lanka");
              if(!$con)
              {
                die("Error while connecting to database");
              }
              $sql="SELECT * FROM `customer` ;";
              $rowSQL= mysqli_query( $con,$sql);
              mysqli_close($con);

              while($row = mysqli_fetch_assoc($rowSQL))
              {
                echo "<tr><td>" . $row['cno'] . "</td><td>" . $row['Name'] . "</td><td>" . $row['Address'] . "</td><td>" . $row['tpno'] . "</td><td>" . $row['type'] . "</td>";

                if ($row['state'] =='active')
                {
                echo "<td>" ." <input type='submit' id='btnUpdate".$row['cno'] ."'  name='btnUpdate".$row['cno'] ."' value='Update Customer'> ";

                echo "<td>" ."<input type='submit' name='btndelete".$row['cno'] ."' id='btndelete".$row['cno'] ."' value= 'Delete Customer' ". "</td>";
                }
                echo "</tr>";
              }
            ?>
          </table>
        </form>
        </div>
      </div>
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


<!--jini-->
