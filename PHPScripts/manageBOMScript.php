<?php
        session_start();
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
            die("Error while connecting to database");
        }
        $sql="SELECT * FROM `BOM` GROUP BY `bom_id`;";
        $rowSQL= mysqli_query( $con,$sql);
        mysqli_close($con);
        while($row=mysqli_fetch_assoc( $rowSQL )){
            if(isset($_POST[$row['bom_id']])){
                $_SESSION['BOM']=$row['bom_id'];
                header('Location:../Pages/viewBOM.php');
            }
        }