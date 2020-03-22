 <?php
    session_start();
    if (isset($_POST['btnNext'])) {
        $sid=$_SESSION['sid'];
        $sql1="SELECT * FROM `materials` WHERE `sid` = '".$sid."';";
        $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
        {
          die("Error while connecting to database");
        }
        $rowSQL2= mysqli_query( $con,$sql1);
        $m="";
        $count=0;
        $count2=0;
        $date=$_POST['txtDate'];
        while($row2=mysqli_fetch_assoc( $rowSQL2 )){
          if(isset($_POST[$row2['mid']])){
            $count++;
            $m=$m.$row2['mid'].'x'.$_POST['txt'.$row2['mid']].',';
            if($_POST['txt'.$row2['mid']]>0){
                $count2++;
            }
          }
        }
        if($count==0){
            header('Location:../Pages/materialsForPO.php?count=0');
        }elseif($count2==0){
            header('Location:../Pages/materialsForPO.php?count2=0');
        }else {
          $_SESSION['PO']=$m;
          $_SESSION['date']=$date;
          header('Location:../Pages/confirmPO.php');
        }
    }