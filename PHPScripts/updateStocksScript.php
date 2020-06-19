<?php

        require 'stock.php';

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

        if (isset($_POST['btnUpdate'])){
          $sql = "select * from `balance_stocks`
                  where extract(month from date)= extract(month from CURDATE())
                  and extract(year from date)= extract(year from CURDATE())";
          $departments =array('store', 'fGoods', 'pFloor');
          if(isset($_GET['sort']) && in_array($_GET['sort'], $departments)){
              $sql="select * from `balance_stocks`
                      where extract(month from date)= extract(month from CURDATE())
                      and extract(year from date)= extract(year from CURDATE())
                      and `dept`='".$_GET['sort']."'";
          }
          $result= mysqli_query($con,$sql);
          if(mysqli_num_rows($result)>0){
            $sql= "delete from balance_stocks
                  where extract(month from date)= extract(month from CURDATE())
                  and extract(year from date)= extract(year from CURDATE())";
            if(isset($_GET['sort']) && in_array($_GET['sort'], $departments)){
                $sql="delete from balance_stocks
                      where extract(month from date)= extract(month from CURDATE())
                      and extract(year from date)= extract(year from CURDATE())
                      and `dept`='".$_GET['sort']."'";
            }
            mysqli_query($con,$sql);
          }

          $departments =array('store', 'fGoods', 'pFloor');
          if(isset($_GET['sort']) && in_array($_GET['sort'], $departments)){
            $stockArr=viewStocksManagerFiltered($sort=$_GET['sort']);
          }else {
            $stockArr=viewStocksManager();
          }

          foreach ($stockArr as $stock){
            $sql="INSERT INTO `balance_stocks`(`no`,`item_name`, `qty`, `type`, `date`, `dept`) VALUES ( NULL,'".$stock->item_name."', '".$_POST['txt'.$stock->dept."".$stock->type."".$stock->item_name]."' ,'".$stock->type."', NOW() ,'".$stock->dept."');";
            mysqli_query($con,$sql);
          }
          header('Location:../Pages/viewStocks.php');
        }
