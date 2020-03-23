<?php
    session_start();
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
            header('Location:../Pages/viewGRN2.php');
        }
    }