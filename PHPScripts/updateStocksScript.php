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
            header('Location:../Pages/updateStocks.php?sort='.$sort);
        }

        $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` GROUP BY dept, item_no, type;";
              if(isset($_GET['sort']) && $_GET['sort']!='all'){
                  $sql="SELECT dept,item_no,type,SUM(qty) as finalstock FROM `stocks` WHERE `dept`='".$_GET['sort']."' GROUP BY dept, item_no, type;";
              }
        $rowSQL= mysqli_query($con,$sql);
        while($row=mysqli_fetch_assoc($rowSQL)){
            
            if(isset($_POST['btnUpdate'.$row['dept'].$row['item_no']])){
                $stock=$row['finalstock'];
                $inputamount= $_POST['txt'.$row['dept'].$row['item_no']];
                $diff=0;
                if($inputamount!=$stock){
                    $diff = $inputamount-$stock;
                    $sql1="INSERT INTO `stocks`(`no`,`item_no`, `qty`, `type`, `date`, `dept`) VALUES ( NULL,'".$row['item_no']."', $diff ,'".$row['type']."', CURDATE() ,'".$row['dept']."');";
                    mysqli_query($con,$sql1);
                    header('Location:../Pages/updateStocks.php');
                } 
            }
        }   