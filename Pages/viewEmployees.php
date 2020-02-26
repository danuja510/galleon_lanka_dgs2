<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>view employees</title>
  </head>
  <body>
    <table>
      <thead>
        <th>
            eno
        </th>
        <th>
            Name
        </th>
        <th>
            Designation
        </th>
        <th>
            Dept
        </th>
        <th>
            Password
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
           $sql="SELECT * FROM `employees` WHERE `status`='active';";
           $rowSQL= mysqli_query( $con,$sql);
           while($row = mysqli_fetch_array( $rowSQL )){
        echo "
        <tr>
          <td>
              ".$row['eno']."
          </td>
          <td>
              ".$row['Name']."
          </td>
          <td>
              ".$row['Designation']."
          </td>
          <td>
              ".$row['Dept']."
          </td>
          <td>
              ".$row['password']."
          </td>
          <td>
              ".$row['status']."
          </td>
        </tr>

        ";
      }
      ?>
      </table>

  </body>
</html>
<!--gima-->
