<?php
    session_start();
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
          header('Location:../Pages/viewInvoice.php');
        }
      }