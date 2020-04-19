<?php
    if(isset($_POST["btnSubmit"])){
    $name=$_POST["txtName"];
    $bom=$_POST["lstBom"];
    $val=$_POST["txtValue"];
    $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con){
            die("Cannot connect to DB server");
        }
        $sql1="INSERT INTO `finished_products` (`Name`, `bom_id`, `value`,`status`) VALUES ('".$name."', '".$bom."', '".$val."','active')";
        mysqli_query($con,$sql1);
        header('Location:../Pages/viewFinishedProducts.php');
    }