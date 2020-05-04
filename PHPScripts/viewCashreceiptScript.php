<?php
session_start();
    $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
          {
            die("Error while connecting to database");
          }
          $sql="SELECT * FROM `cash_receipts` GROUP BY `cr_no`;";
          $rowSQL= mysqli_query( $con,$sql);
          while($row=mysqli_fetch_assoc( $rowSQL )){
            if(isset($_POST[$row['cr_no']])){
              $_SESSION['CR']=$row['cr_no'];
              header('Location:../Pages/manageCashreceipt.php');
            }
          }
