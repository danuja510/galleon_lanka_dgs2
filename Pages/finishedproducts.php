<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Finished products</title>
  </head>
  <body>
    <h1>add finished products</h1>
    <form class="" action="finishedproducts.php" method="post">
      <table>
        <tr>
          <td><label for="txtName">Name</label></td>
          <td><input type="text" name="txtName" id="txtName" value=""></td>
        </tr>

        <tr>
          <td><label for="lstBom">BOM ID</label></td>
          <td>
            <select name="lstBom" id="lstBom">
              <option value='-----'>-----</option>
              <?php
                $sql="SELECT * FROM `bom`;";
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $rowSQL= mysqli_query( $con,$sql);
      					while($row=mysqli_fetch_assoc( $rowSQL )){
                  echo "
                    <option value='".$row['bom_id']."'> ".$row['bom_id']." </option>
                  ";
                }
                mysqli_close($con);
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="btnSubmit" value="submit"></td>
        </tr>
      </table>
    </form>
  </body>
</html>

<!--gima-->
