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

        <tr>
          <td>
            <label for='lstBomid'>BOM ID</label>
          </td>
          <td>
            <select name='lstBomid' id='lstBomid'>

                <option value=".$row['bom_id'].">
                   ".$row['bom_id']."
                </option>

                <option value=''>
                   -----
                </option>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtValue'>value</label>
          </td>
          <td>
            <input type='text' name='txtValue' id='txtValue' value=" .$row['value']. " required>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtStatus'>status</label>
          </td>
          <td>
            <input type='text' name='txtStatus' id='txtStatus' value=" .$row['status']. " readonly>
            ";
            ?>

          </td>
        </tr>

      </table>
    </form>

  </body>
</html>
<!--gima-->
