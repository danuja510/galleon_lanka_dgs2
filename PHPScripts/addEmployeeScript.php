<?php
    if(isset($_POST['btnSubmit']))
    {
    $name = $_POST['txtName'];
    $dept = $_POST['lstDepartment'];
    $pwd = $_POST['txtconPwd'];
    $email=$_POST['txtEmail'];

    $con1 = mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con1)
        {
            die("cannot connect to DB server");
        }
    $sql1="INSERT INTO `employees`(`Name`, `Designation`, `Dept`, `password`,`email`,`status`) VALUES ('".$name."','Employee','".$dept."','".md5($pwd)."','".$email."','active');";
    mysqli_query($con1,$sql1);
    header('Location:../Pages/viewEmployees.php');
    }
