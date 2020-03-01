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
    <form method="post" action="viewEmployees.php">

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
          ";

        echo "
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
              ".$row['status']."
          </td>
          <td>
              <input type='submit' name='".$row['eno']."' value='edit'>
          ";

              echo"
          </td>
          </tr>
          ";



            }
            mysqli_close($con);
            ?>




      </table>
      </form>
<?php
          //  $eno=$row['eno'];
          $con = mysqli_connect("localhost","root","","galleon_lanka");
            if(!$con)
              {
               die("cannot connect to DB server");
              }
             $sql="SELECT * FROM `employees` WHERE `status`='active';";
             $rowSQL= mysqli_query( $con,$sql);
          while($row = mysqli_fetch_array( $rowSQL )){
            if (isset($_POST[$row['eno']])) {
              $_SESSION['eno2']=$row['eno'];
              header('Location:manageEmployees.php');
            }
          }
          mysqli_close($con);
            ?>


  </body>
</html>
<!--gima-->
