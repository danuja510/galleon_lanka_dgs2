<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }elseif ($_SESSION['DEPT']=='pFloor' || $_SESSION['DEPT']=='fGoods'){
    header('Location:empHome.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>View Materials</title>
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
                <a href="empHome.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
  <section class="section-manage">
    <div class="row">
      <div class="col span-1-of-7">
      <a href="addMaterials.php">
        <div class="new">
          <i class="ion-ios-compose-outline"></i>
          New Material
        </div>
      </a>
    </div>

      <div class="col span-6-of-7">
    <form action="../PHPScripts/ViewMaterialsScript.php" method="post">
    <table>
      <thead>
        <th>
            MID
        </th>
        <th>
            Name
        </th>
        <th>
            Type
        </th>
        <th>
            Supplier ID
        </th>
        <th>
            Value
        </th>
        <th>
            Status
        </th>
      </thead>

      <?php
     $con = mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con)
         {
          die("cannot connect to DB server");
         }
        $sql="SELECT * FROM `materials`;";
        $rowSQL= mysqli_query( $con,$sql);
        while($row = mysqli_fetch_array($rowSQL)){
echo "
     <tr>
       <td>
           ".$row['mid']."
       </td>
       <td>
           ".$row['Name']."
       </td>
       <td>
           ".$row['Type']."
       </td>
       <td>
           ".$row['sid']."
       </td>
       <td>
           ".$row['value']."
       </td>
       <td>
           ".$row['status']."
       </td>
       <td class='bt'>
           <input type='submit' name='".$row['mid']."' value='view'>

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
</body>
</html>
<!--sithara-->
