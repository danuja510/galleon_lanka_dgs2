<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DES']!='Manager') {
    header('Location:empHome.php');
  }elseif(!isset($_SESSION['BOM'])){
    header('Location:manageBOM.php');
  }

  $con = mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con)
  {
      die("Error while connecting to database");
  }
  $sql="SELECT `state` FROM `bom` WHERE `bom_id` = '".$_SESSION['BOM']."' GROUP BY `bom_id`;";
  $rowSQL= mysqli_query( $con,$sql);
  mysqli_close($con);
  $row = mysqli_fetch_array( $rowSQL );
  if($row['state']=='active'){
    $active=TRUE;
    $state='active';
  }
  else{
    $state='inactive';
    $active=FALSE;
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
    <link rel="stylesheet" type="text/css" href="../StyleSheets/viewStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>viewBOM</title>
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
    <datalist id="lstBOM">
      <?php
        $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con){
          die("Cannot connect to DB server");
        }
        $sql="SELECT DISTINCT Name FROM `materials`";
        $rowSQL= mysqli_query( $con,$sql);
        while($row=mysqli_fetch_assoc( $rowSQL )){
          echo "<option value='".$row["Name"]."'>";
        }
        mysqli_close($con);
      ?>
    </datalist>
      <section class="section-view">
        <div class="row">
          <div class="col span-1-of-4">
              <div style="margin-top:25px;" class="row">
                  <div class="col span-1-of-2">
                 <?php
                  echo "BOM ID";
                  ?>
              </div>
              <div class="col span-1-of-2">
                  <?php
                  echo $_SESSION['BOM'];;
                  ?>
              </div>
              </div>
              <div class="row">
                  <div class="col span-1-of-2">
                 <?php
                  echo "State";
                  ?>
              </div>
              <div class="col span-1-of-2">
                  <?php
                  echo $state;
                  ?>
              </div>
              </div>

            <?php

    if ($active) {
        echo "<form action='../PHPScripts/viewBOMScript.php' method='post'>";
    }
            $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
            {
                die("Error while connecting to database");
            }
      ?>
            </div>
          <div class="col span-3-of-4">
              <div class="row">
                 <div class="col span-1-of-3 th"><h3>Material Name</h3></div>
                 <div class="col span-1-of-3 th"><h3>Qty.</h3></div>
                 <div class="col span-1-of-3 th">&nbsp;</div>
              </div>
            <?php
    $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
    $rowSQL= mysqli_query( $con,$sql);
    mysqli_close($con);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $dm="";
      $readonly="readonly";
      if ($active) {
        $dm="<button type='submit' class='btn-del' name='btnDeteleM".$row['no']."'><i class='ion-ios-trash'></i></button>";
        $readonly="";
      }
      echo "<div class='row'>
                 <div class='col span-1-of-3 td'>".$row['mName']."</div>
                 <div class='col span-1-of-3 td'><input type='number' value='".$row['qty']."' name='txtQty".$row['no']."' min=1 ".$readonly." required></div>
                 <div class='col span-1-of-3'>".$dm."</div>
              </div>";
    }
    if ($active) {
      echo "<div class='row'>
                 <div class='col span-1-of-3 td'><input type='text' id='txtName' name='txtName' list='lstBOM'></div>
                 <div class='col span-1-of-3 td'><input type='number' id='txtQtyN' name='txtQtyN' min=1></div>
                 <div class='col span-1-of-3 td'><input type='submit' onclick='validate()' value ='Add' id='btnAdd' name='btnAdd'></div>
              </div>";
    }?>
                <div class="row">
                   <div class="col span-2-of-2 td">
                       <?php
              echo "<input type='submit' value='Update' name='btnUpdate'>";
      echo "<input type='submit' id='btnDelete' value='Delete' name='btnDelete'>";
              ?>
                    </div>
                </div>
              </form>
        </div>
        </div>
      </section>
      <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  <script type="text/javascript">
  function validateName(){
    var mName=document.getElementById("txtName").value;
    if (mName=="") {
      alert('Please Enter a Name of a Material to Add');
      return false;
    }else{
      return true;
    }
  }
  function validateQty(){
    var qty=document.getElementById("txtQtyN").value;
    if (qty=="") {
      alert('Please Enter the Quantity of Materials to Add');
      return false;
    }else{
      return true;
    }
  }
  function validate()
  {
    if(validateName() && validateQty())
      {}
    else
      event.preventDefault();
  }
  </script>
  </body>
</html>
<!--dan-->
