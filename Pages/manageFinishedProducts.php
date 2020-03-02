<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['fpid'])) {
    header('Location:viewFinishedProducts.php');
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage FP</title>
  </head>
  <body>
  <?php
  $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
         die("cannot connect to DB server");
        }
      $fp=$_SESSION['fpid'];
       $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
       $rowSQL= mysqli_query( $con,$sql);
       $row = mysqli_fetch_assoc( $rowSQL);

echo"
    <form action='manageFinishedProducts.php' method='post'>
      <table>

        <tr>
          <td>
            <label for='txtFpid'>FP ID</label>
          </td>
          <td>

            <input type='text' name='txtFpid' id='txtFpid' value=" .$row['fp_id']. " required readonly>
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
";
echo "
        <tr>
          <td>
            <label for='lstBomid'>BOM ID</label>
          </td>
          <td>
            <select name='lstBomid' id='lstBomid'>

                <option value=".$row['bom_id'].">
                   ".$row['bom_id']."
                </option>
";
                $bom=$row['bom_id'];
                $sql2="SELECT distinct `bom_id` FROM `bom` where `bom_id` != '$bom' ;";
                $rowSQL= mysqli_query( $con,$sql2);
                while($row = mysqli_fetch_assoc( $rowSQL)){
echo"
                <option value='".$row['bom_id']."'>
                   ".$row['bom_id']."
                </option>
";
              }
echo "
            </select>
          </td>
        </tr>
          ";
          $sql="SELECT * FROM `finished_products` where `fp_id`='$fp';";
          $rowSQL= mysqli_query( $con,$sql);
          $row = mysqli_fetch_assoc( $rowSQL);
echo"
        <tr>
          <td>
            <label for='txtValue'>value</label>
          </td>
          <td>
            <input type='text' name='txtValue' id='txtValue' value=".$row['value']." required>
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
      $b=$_POST["lstBomid"];
      $val=$_POST["txtValue"];
      $con=mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con){
        die("Cannot connect to DB server");
      }
      $sql3="UPDATE `finished_products` SET `Name` = '".$name."',`bom_id`='".$b."', `value` = '".$val."' WHERE `fp_id` = '".$_SESSION['fpid']."'";
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
        $sql4="UPDATE `finished_products` SET `status` = 'inactive' WHERE `fp_id` = '".$_SESSION['fpid']."'";
        mysqli_query($con,$sql4);
        mysqli_close($con);
        }
         ?>

  </body>
</html>
<!--gima-->
