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
    <title>Manage GRN</title>
  </head>
  <body>
    <form action="viewGRN.php" method="post">
      <table>
        <thead>
          <th>GRN no.</th>
          <th>Supplier</th>
          <th>Date</th>
          <th>Prepared By(eno)</th>
          <th>Stauts</th>
          <th></th>
        </thead>
        <?php
          $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `grn` GROUP BY `grn_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          mysqli_close($con);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            if($row['approvedBy']!=null){
              $approve='approved';
            }else{
              $approve='pending';
            }
            echo "
              <tr>
                <td>
                ".$row['grn_no']."
                </td>
                <td>
                ".$row['sid']."
                </td>
                <td>
                ".$row['date']."
                </td>
                <td>
                  ".$row['prepared_by_(eno)']."
                </td>
                <td>
                  ".$approve."
                </td>
                <td>
                  <input type='submit' name='".$row['grn_no']."' value='view'>
                </td>
              </tr>
            ";
          }
        ?>
      </table>
    </form>
  </body>
  <?php
    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("Error while connecting to database");
    }
    $sql="SELECT * FROM `grn` GROUP BY `grn_no`;";
    $rowSQL= mysqli_query( $con,$sql);
    mysqli_close($con);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      if(isset($_POST[$row['grn_no']])){
        $_SESSION['grn']=$row['grn_no'];
        header('Location:viewGRN2.php');
      }
    }
  ?>
</html>
<!--dan-->
