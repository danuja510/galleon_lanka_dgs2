<?php
    session_start();
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
            header('Location:../Pages/viewGTN.php');
        }
    }
      