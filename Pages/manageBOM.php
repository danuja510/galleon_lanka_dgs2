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
    <title>manageBOMs</title>
  </head>
  <body>
    <form action="manageBOM.php" method="post">
      <table>
        <thead>
          <th>BOM ID</th><th>State</th><th>&nbsp;</th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `bom` GROUP BY `bom_id`;";
          $rowSQL= mysqli_query( $con,$sql);
          mysqli_close($con);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            echo "
              <tr>
                <td>".$row['bom_id']."</td>
                <td>".$row['state']."</td>
                <td><input type='submit' value='view' name='".$row['bom_id']."'></td>
              </tr>
            ";
          }
        ?>
      </table>
    </form>
    <?php
        //session_start();
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
            die("Error while connecting to database");
        }
        $sql="SELECT * FROM `BOM` GROUP BY `bom_id`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        while($row=mysqli_fetch_assoc( $rowSQL )){
            if(isset($_POST[$row['bom_id']])){
                $_SESSION['BOM']=$row['bom_id'];
                header('Location:viewBOM.php');
            }
        }
    ?>
  </body>
</html>
<!--dan-->
