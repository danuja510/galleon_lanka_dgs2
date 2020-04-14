<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['mid'])) {
    header('Location:viewMaterials.php');
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage Materials</title>
  </head>
  <body>
  <?php
    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
         die("cannot connect to DB server");
        }
      $material=$_SESSION['mid'];
       $sql="SELECT * FROM `materials` where `mid`='$material';";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_assoc( $rowSQL);
       $t=$row['Type'];

echo"
    <form action='manageMaterials.php' method='post'>
      <table>

        <tr>
          <td>
            <label for='txtMid'>M_ID</label>
          </td>
          <td>

            <input type='text' name='txtMid' id='txtMid' value=" .$row['mid']. " required readonly>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtName'>Name</label>
          </td>
          <td>
            <input type='text' name='txtName' id='txtName' value=" .$row['Name']. " required>
          </td>
        </tr>


        <tr>
          <td>
            <label for='lstSupplier'>Supplier</label>
          </td>
          <td>
            <select name='lstSupplier' id='lstSupplier'>

                <option value=".$row['sid'].">
                   ".$row['sid']."
                </option>
";
                $sid=$row['sid'];
                $sql2="SELECT distinct `sid`, `Name` FROM `supplier` where `sid` != '$sid' ;";
                $rowSQL= mysqli_query( $con,$sql2);

                while($row = mysqli_fetch_assoc( $rowSQL)){
echo"
                <option value='".$row['sid']."'>
                   ".$row['sid']."
                </option>
";
              }
echo "
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <label for='lstType'>Type</label>
          </td>
          <td>
            <select name='lstType' id='lstType'>

                <option value=".$t.">
                   ".$t."
                </option>
";
                $type=$row['Type'];
                $sql2="SELECT distinct `type` FROM `materials` where `type` != '$t' ;";
                $rowSQL= mysqli_query( $con,$sql2);
                while($row = mysqli_fetch_assoc( $rowSQL)){
echo"
                <option value='".$row['type']."'>
                   ".$row['type']."
                </option>
";
              }
echo "
            </select>
          </td>
        </tr>
          ";

          $sql="SELECT * FROM `materials` where `mid`='$material';";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_assoc( $rowSQL);
echo"
        <tr>
          <td>
            <label for='txtValue'>value</label>
          </td>
          <td>
            <input type='number' name='txtValue' id='txtValue' value=".$row['value']." min='0' step='0.01' required>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtStatus'>status</label>
          </td>
          <td>
            <input type='text' name='txtStatus' id='txtStatus' value=" .$row['status']. " readonly>
            </td>
        </tr>

        <tr>
          <td>
              <input type='submit' name='btnUpdate' value='update'>
          </td>

          <td>
";
        $st=$row['status'];
        if($st=='active'){
echo"
              <input type='submit' name='btnDelete' id='btnDelete' value='delete'>
";
        }
echo"
        </tr>
";
            ?>
      </table>
    </form>

    <?php
    if(isset($_POST["btnUpdate"])){

      $name=$_POST["txtName"];
      $type=$_POST["lstType"];
      $s=$_POST["lstSupplier"];
      $val=$_POST["txtValue"];
      $con=mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con){
        die("Cannot connect to DB server");
      }
      $sql3="UPDATE `materials` SET `Name` = '".$name."',`Type`='".$type."', `sid`='".$s."', `value` = '".$val."' WHERE `mid` = '".$_SESSION['mid']."'";
      mysqli_query($con,$sql3);
      mysqli_close($con);
      }
      ?>

      <?php
      if(isset($_POST["btnDelete"])){
        $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con){
          die("Cannot connect to DB server");
        }
        $sql4="UPDATE `materials` SET `status` = 'inactive' WHERE `mid` = '".$_SESSION['mid']."'";
        mysqli_query($con,$sql4);
        mysqli_close($con);
        }
         ?>

  </body>
</html>
<!--sithara-->
