<?php
    session_start();
    if (isset($_POST['btnDelete'])) {
        unset($_SESSION["bom"]);
        header('Location:../Pages/addBOM.php');
    }
                
    if (isset($_POST['btnNext'])) {
        header('Location:../Pages/addBOM.php');
    }
                
    if (isset($_POST['btnConfirm'])) {
      $con=mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con){
        die("Cannot connect to DB server");
      }
      $rowSQL = mysqli_query( $con,"SELECT MAX( bom_id ) AS max FROM `bom`;" );
      $row = mysqli_fetch_array( $rowSQL );
      $max = $row['max'];
      $bom_id=$max+1;
      for ($i=0; $i <sizeof($_SESSION["bom"]) ; $i++) {
        $bom=explode(',',$_SESSION["bom"][$i]);
        $sql="INSERT INTO `bom` (`no`, `bom_id`, `mName`, `qty`, `state`) VALUES (NULL, '".$bom_id."', '".$bom[0]."', '".$bom[1]."', 'active');";
        mysqli_query( $con, $sql);
      }
      mysqli_close($con);
      unset($_SESSION["bom"]);
      header('Location:../Pages/manageBOM.php');
    }