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
      </thead>

      <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
            {
             die("cannot connect to DB server");
            }
           $sql="SELECT * FROM `finished_products`;";
           $rowSQL= mysqli_query( $con,$sql);
           while($row = mysqli_fetch_array( $rowSQL )){
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
        </tr>
      </table>
        ";
      }
      ?>

  </body>
</html>
<!--gima-->
