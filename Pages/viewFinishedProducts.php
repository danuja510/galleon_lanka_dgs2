<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>view finished products</title>
  </head>
  <body>
    <form action="viewFinishedProducts.php" method="post">
    <table>
      <thead>
        <th>
            FP_ID
        </th>
        <th>
            Name
        </th>
        <th>
            BOM_ID
        </th>
        <th>
            value
        </th>
        <th>
            status
        </th>
      </thead>

      <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
            {
             die("cannot connect to DB server");
            }
           $sql="SELECT * FROM `finished_products` WHERE `status`='active';";
           $rowSQL= mysqli_query( $con,$sql);
           while($row = mysqli_fetch_array($rowSQL)){
        echo "
        <tr>
          <td>
              ".$row['fp_id']."
          </td>
          <td>
              ".$row['Name']."
          </td>
          <td>
              ".$row['bom_id']."
          </td>
          <td>
              ".$row['value']."
          </td>
          <td>
              ".$row['status']."
          </td>
          <td>
              <input type='submit' name='".$row['fp_id']."' value='edit'>
          </td>
        </tr>

        ";
      }

      mysqli_close($con);
      ?>

  </table>
    </form>

    <?php

    $con1 = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con1)
        {
         die("cannot connect to DB server");
        }

       $sql="SELECT * FROM `finished_products` WHERE `status`='active';";
       $rowSQL= mysqli_query( $con1,$sql);

      while($row = mysqli_fetch_array( $rowSQL )){

        if (isset($_POST[$row['fp_id']])) {
          $_SESSION['fpid']=$row['fp_id'];
          header('Location:manageFinishedProducts.php');
        }
      }
      mysqli_close($con1);

     ?>
  </body>
</html>
<!--gima-->
