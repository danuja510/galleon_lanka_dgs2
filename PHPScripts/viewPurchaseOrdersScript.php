<?php
session_start();
    $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `purchase_orders` GROUP BY `po_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            if(isset($_POST[$row['po_no']])){
              $_SESSION['pOrder']=$row['po_no'];
              header('Location:../Pages/managePurchaseOrder.php');
            }
          }
