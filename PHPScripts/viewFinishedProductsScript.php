<?php
    session_start();
     $con = mysqli_connect("localhost","root","","galleon_lanka");
          if(!$con)
            {
             die("cannot connect to DB server");
            }

           $sql="SELECT * FROM `finished_products`;";
           $rowSQL= mysqli_query( $con,$sql);

          while($row = mysqli_fetch_array( $rowSQL ))
          {
            if (isset($_POST[$row['fp_id']])) {
              $_SESSION['fpid']=$row['fp_id'];
              header('Location:../Pages/manageFinishedProducts.php');
            }
          }