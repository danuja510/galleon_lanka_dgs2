<?php
        $con=mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("cannot connect to DB server");
        }
        $sort="";
        if(isset($_POST['btnSort']))
        {
            $sort=$_POST['lstDepartment'];
            header('Location:../Pages/viewStocks.php?sort='.$sort);
        }