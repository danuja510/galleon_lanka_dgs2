<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>view employees</title>
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
            <div class="col span-2-of-2">
                <form method="post" action="viewEmployees.php">
        <table>
          <thead>
                <th>
                    eno
                </th>
                <th>
                    Name
                </th>
                <th>
                    Designation
                </th>
                <th>
                    Dept
                </th>
                <th>
                    status
                </th>
                <th>
                    edit
                </th>
          </thead>

      <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
            {
             die("cannot connect to DB server");
            }
           $sql="SELECT * FROM `employees`;";
           $rowSQL= mysqli_query( $con,$sql);
           while($row = mysqli_fetch_array( $rowSQL )){
        echo "
        <tr>
          <td>
          ";

        echo "
              ".$row['eno']."
          </td>

          <td>
              ".$row['Name']."
          </td>

          <td>
              ".$row['Designation']."
          </td>

          <td>
              ".$row['Dept']."
          </td>

          <td>
              ".$row['status']."
          </td>
          <td>
          ";
          $st=$row['status'];
            if($st=="active")
            {
              echo"
              <input type='submit' name='".$row['eno']."' value='edit'>
              ";
            }
              echo"
          </td>
          </tr>
          ";
            }
            mysqli_close($con);
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
      
<?php
          //  $eno=$row['eno'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
              {
               die("cannot connect to DB server");
              }
             $sql="SELECT * FROM `employees` WHERE `status`='active';";
             $rowSQL= mysqli_query( $con,$sql);
          while($row = mysqli_fetch_array( $rowSQL )){
            if (isset($_POST[$row['eno']])) {
              $_SESSION['eno2']=$row['eno'];
              header('Location:manageEmployees.php');
            }
          }
          mysqli_close($con);
            ?>
  </body>
</html>
<!--gima-->
