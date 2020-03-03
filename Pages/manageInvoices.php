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
    <title>ManageInvoices</title>
  </head>
  <body>
    <form action="manageInvoices.php" method="post">
      <table>
        <thead>
          <th>Invoice no.</th>
          <th>Customer</th>
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
          $sql="SELECT * FROM `invoice` GROUP BY `invoice_no`;";
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
                <td>
                ".$row['invoice_no']."
                </td>
                <td>
                ".$row['cno']."
                </td>
                <td>
                ".$row['date']."
                </td>
                <td>
                  ".$row['prepared_by']."
                </td>
                <td>
                  ".$approve."
                </td>
                <td>
                  <input type='submit' name='".$row['invoice_no']."' value='view'>
                </td>
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
      $sql="SELECT * FROM `invoice` GROUP BY `invoice_no`;";
      $rowSQL= mysqli_query( $con,$sql);
      mysqli_close($con);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        if(isset($_POST[$row['invoice_no']])){
          $_SESSION['invoice']=$row['invoice_no'];
          header('Location:viewInvoice.php');
        }
      }
    ?>
  </body>
</html>
