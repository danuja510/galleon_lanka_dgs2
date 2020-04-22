<?php
    session_start();
    if (isset($_POST['btnUpdate'])) {
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
      $rowSQL= mysqli_query( $con,$sql);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        $sql2="UPDATE `bom` SET `qty` = '".$_POST['txtQty'.$row['no']]."' WHERE `bom`.`no` = ".$row['no'].";";
        mysqli_query( $con,$sql2);
      }
      mysqli_close($con);
      header('Location:../Pages/viewBOM.php');
    }

    if(isset($_POST['btnDelete'])){
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql3="UPDATE `bom` SET `state` = 'inactive' WHERE `bom`.`bom_id` = ".$_SESSION['BOM'].";";
      mysqli_query( $con,$sql3);
      mysqli_close($con);
      header('Location:../Pages/viewBOM.php');
    }

    $con = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
        die("Error while connecting to database");
    }
    $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
    $rowSQL= mysqli_query( $con,$sql);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      if (isset($_POST['btnDeteleM'.$row['no']])) {
        $sql4="DELETE FROM `bom` WHERE `no`=".$row['no'];
        mysqli_query( $con,$sql4);
        header('Location:../Pages/viewBOM.php');
      }
    }

    if (isset($_POST['btnAdd'])) {
      $mName=$_POST['txtName'];
      $qty=$_POST['txtQtyN'];
      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
          die("Error while connecting to database");
      }
      $sql="SELECT * FROM `bom` WHERE `bom_id`=".$_SESSION['BOM'].";";
      $rowSQL= mysqli_query( $con,$sql);
      $found=FALSE;
      while($row=mysqli_fetch_assoc( $rowSQL )){
        if ($row['mName']==$mName) {
          $sql5="UPDATE `bom` SET `qty` = '".($row['qty']+$qty)."' WHERE `bom`.`no` = ".$row['no'].";";
          mysqli_query( $con,$sql5);
          $found=TRUE;
          header('Location:../Pages/viewBOM.php');
        }
      }
      if (!$found) {
        $sql7="INSERT INTO `bom` (`no`, `bom_id`, `mName`, `qty`, `state`) VALUES (NULL, '".$_SESSION['BOM']."', '".$mName."', '".$qty."', 'active');";
        mysqli_query( $con,$sql7);
      }
      mysqli_close($con);
      header('Location:../Pages/viewBOM.php');
    }