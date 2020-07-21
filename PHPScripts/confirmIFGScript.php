<?php
    session_start();
    if (isset($_POST['btnConfirm'])) {
        //updating/inserting finished goods to stocks
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i <sizeof($_SESSION['USQ_1']) ; $i++) {
          mysqli_query( $con,$_SESSION['USQ_1'][$i]);
        }

        $query2=[];
        $ifg=$_SESSION['ifg'];
        $ifgs=explode(',',$ifg);
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        for ($i=0; $i <sizeof($ifgs)-1 ; $i++) {
          $order=explode('x',$ifgs[$i]);
          if ($order[1]==0) {
          }else {
            $sql="SELECT * FROM `finished_products` WHERE `fp_id` = ".$order[0].";";
            $rowSQL= mysqli_query( $con,$sql);
            $row = mysqli_fetch_array( $rowSQL );
            $bom=$row['bom_id'];
            $sql="select * from bom where bom_id = '".$bom."'";
            $rowSQL= mysqli_query( $con,$sql);
            while($row = mysqli_fetch_assoc( $rowSQL )){
              $sql="insert into stocks values (NULL, '".$row['mName']."', '".-$row['qty']*$order[1]."', 'material', NOW(), 'pFloor')";
              mysqli_query( $con,$sql);
            }
          }
        }
        mysqli_close($con);
        unset($_SESSION['USQ_1']);
        header('Location:../Pages/viewStocks.php');
      }
