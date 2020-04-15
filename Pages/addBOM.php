<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>addBOM</title>
  </head>
  <body>
    <form action="addBOM.php" method="post">
      <label for="txtName">BOM Name</label>
      <input type="text" name="txtName" list="lstBOM" required><br>
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
      <label for="txtQty">Qty.</label>
      <input type="number" name="txtQty" min=1 required>
      <input type="submit" name="btnSubmit" value="Next">
      <button type="submit" name="btnNext">Add Another Material</button>
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        if (isset($_SESSION["bom"])) {
          $found=FALSE;
          for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
            $bom=explode(',',$_SESSION["bom"][$i]);
            if ($bom[0]==$_POST['txtName']) {
              $_SESSION["bom"][$i]="".$_POST['txtName'].",".($bom[1]+$_POST['txtQty'])."";
              $found=TRUE;
              header('Location:addBOM.php');
            }
          }
          if (!$found==TRUE) {
            $_SESSION["bom"][sizeof($_SESSION["bom"])]=$_POST['txtName'].",".$_POST['txtQty'];
            header('Location:addBOM.php');
          }
        }else{
          $_SESSION["bom"]=[];
          $_SESSION["bom"][0]=$_POST['txtName'].",".$_POST['txtQty'];
          header('Location:addBOM.php');
        }
      }

      if (isset($_POST['btnSubmit'])) {
        if (isset($_SESSION["bom"])) {
          $found=FALSE;
          for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
            $bom=explode(',',$_SESSION["bom"][$i]);
            if ($bom[0]==$_POST['txtName']) {
              $_SESSION["bom"][$i]="".$bom[0].",".($bom[1]+$_POST['txtQty'])."";
              $found=TRUE;
            }
          }
          if (!$found==TRUE) {
            $_SESSION["bom"][sizeof($_SESSION["bom"])]=$_POST['txtName'].",".$_POST['txtQty'];
          }
        }else{
          $_SESSION["bom"]=[];
          $_SESSION["bom"][0]=$_POST['txtName'].",".$_POST['txtQty'];

        }
        header('Location:confirmBOM.php');
      }
    ?>
  </body>
</html>
<!--dan-->
