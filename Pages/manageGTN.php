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
    <title>manageGTN</title>
  </head>
  <body>
      <form action="manageGTN.php" method="post">
        <table>
          <thead>
            <th>GTN No.</th>
            <th>Department</th>
            <th>Type</th>
            <th>Date</th>
            <th>Status</th>
            <th></th>
          </thead>
          <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `gtn` GROUP BY `gtn_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          mysqli_close($con);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            if($row['approved_by']!=null){
              $approve='approved';
            }else{
              $approve='pending';
            }
            echo "
              <tr>
                <td>".$row['gtn_no']."</td>
                <td>".$row['dept']."</td>
                <td>".$row['type']."</td>
                <td>".$row['date']."</td>
                <td>".$approve."</td>
                <td><input type='submit' value='view' name='".$row['gtn_no']."'></td>
              </tr>
            ";
          }
          ?>
        </table>
      </form>
      <?php
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $sql="SELECT * FROM `gtn` GROUP BY `gtn_no`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        while($row=mysqli_fetch_assoc( $rowSQL )){
          if(isset($_POST[$row['gtn_no']])){
            $_SESSION['gtn']=$row['gtn_no'];
            header('Location:viewGTN.php');
          }
        }
      ?>
  </body>
</html>
<!--dan-->
