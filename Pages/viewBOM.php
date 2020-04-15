<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
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
    <title>viewBOM</title>
  </head>
  <body>
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
  <?php
    echo "BOM id = ".$_SESSION['BOM'];
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
        die("Error while connecting to database");
    }
    echo "state =".$state;
    echo "<table><thead><th>Material Name</th><th>Qty.</th><th></th></thead>";
    echo "<form action='viewBOM.php' method='post'>";
    $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
    $rowSQL= mysqli_query( $con,$sql);
    mysqli_close($con);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $dm="";
      $readonly="readonly";
      if ($active) {
        $dm="<button type='submit' name='btnDeteleM".$row['no']."'>DM</button>";
        $readonly="";
      }
      echo "<tr><td>".$row['mName']."</td><td><input type='number' value='".$row['qty']."' name='txtQty".$row['no']."' min=1 ".$readonly." required></td><td>".$dm."</td></tr>";
    }
    if ($active) {
      echo "<tr><td><input type='text' id='txtName' name='txtName' list='lstBOM'></td><td><input type='number' id='txtQtyN' name='txtQtyN' min=1></td><td><input type='submit' onclick='validate()' value ='Add' id='btnAdd' name='btnAdd'></td></tr>";
    }
    echo "</table>";
    if ($active) {
      echo "<input type='submit' value='Update' name='btnUpdate'>";
      echo "<input type='submit' value='Delete' name='btnDelete'>";
    }
    echo "</form>";
  ?>
  <?php
    if (isset($_POST['btnUpdate'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
      $rowSQL= mysqli_query( $con,$sql);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        $sql2="UPDATE `bom` SET `qty` = '".$_POST['txtQty'.$row['no']]."' WHERE `bom`.`no` = ".$row['no'].";";
        mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
      header('Location:viewBOM.php');
    }

    if(isset($_POST['btnDelete'])){
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql3="UPDATE `bom` SET `state` = 'inactive' WHERE `bom`.`bom_id` = ".$_SESSION['BOM'].";";
      mysqli_query( $con,$sql3);
      mysqli_close($con);
      unset($_SESSION['BOM']);
      header('Location:manageBOM.php');
    }

    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
        die("Error while connecting to database");
    }
    $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
    $rowSQL= mysqli_query( $con,$sql);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      if (isset($_POST['btnDeteleM'.$row['no']])) {
        $sql4="DELETE FROM `bom` WHERE `no`=".$row['no'];
        mysqli_query( $con,$sql4);
        header('Location:viewBOM.php');
      }
    }

    if (isset($_POST['btnAdd'])) {
      $mName=$_POST['txtName'];
      $qty=$_POST['txtQtyN'];
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
      $rowSQL= mysqli_query( $con,$sql);
      $found=FALSE;
      while($row=mysqli_fetch_assoc( $rowSQL )){
        if ($row['mName']==$mName) {
          $sql5="UPDATE `bom` SET `qty` = '".($row['qty']+$qty)."' WHERE `bom`.`no` = ".$row['no'].";";
          mysqli_query( $con,$sql5);
          $found=TRUE;
          header('Location:viewBOM.php');
        }
      }
      if (!$found) {
        $sql7="INSERT INTO `bom` (`no`, `bom_id`, `mName`, `qty`, `state`) VALUES (NULL, '".$_SESSION['BOM']."', '".$mName."', '".$qty."', 'active');";
        mysqli_query( $con,$sql7);
      }
      mysqli_close($con);
      header('Location:viewBOM.php');
    }
  ?>
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
