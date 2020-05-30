<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }elseif ($_SESSION['DES']!='Manager') {
    header('Location:empHome.php');
  }

  class efficiency{

    public $itemID;
    public $eff;
    public $dif;
    public $in =0;
    public $bf =0;
    public $stock =0;
    public $out =0;

    function __construct($itemID){
      $this->itemID = $itemID;
    }
  }

    function efClass(float $ef){
        if($ef==1){
            $class="light-green";
        }elseif($ef>1){
            if($ef<1.25){
                $class="green";
            }elseif($ef<1.5){
                $class="yellow";
            }elseif($ef<1.75){
                $class="orange";
            }else{
                $class="red";
            }
        }else{
            if($ef>0.75){
                $class="yellow";
            }elseif($ef>0.5){
                $class="orange";
            }else{
                $class="red";
            }
        }
        return $class;
    }

  $bbfdate="";
  $curdate="";
  $stockdate="";
  $dateDisplay="";
  if (isset($_GET['y'])&&isset($_GET['m'])) {
    $bbfdate="AND date<'".$_GET['y']."-".$_GET['m']."-01'";
    $stockdate="AND date<='".$_GET['y']."-".($_GET['m']+1)."-01'";
    $curdate="AND extract(year from date)=".$_GET['y']." and extract(month from date)=".$_GET['m']."";
    $dateDisplay="For ".$_GET['y'].", ";
    switch ($_GET['m']) {
      case 1:
        $dateDisplay.="January";
        break;
      case 2:
        $dateDisplay.="February";
        break;
      case 3:
        $dateDisplay.="March";
        break;
      case 4:
        $dateDisplay.="April";
        break;
      case 5:
        $dateDisplay.="May";
        break;
      case 6:
        $dateDisplay.="June";
        break;
      case 7:
        $dateDisplay.="July";
        break;
      case 8:
        $dateDisplay.="August";
        break;
      case 9:
        $dateDisplay.="September";
        break;
      case 10:
        $dateDisplay.="Octomber";
        break;
      case 11:
        $dateDisplay.="November";
        break;
      case 12:
        $dateDisplay.="December";
        break;
    }
  }elseif (isset($_GET['y'])&&!isset($_GET['m'])) {
    $bbfdate="AND date<'".$_GET['y']."-01-01'";
    $stockdate="AND date<='".($_GET['y']+1)."-01-01'";
    $curdate="AND extract(year from date)=".$_GET['y'];
    $dateDisplay="For ".$_GET['y'];
  }

  $con=mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con){
    die("Cannot connect to DB server");
  }


  //efficiency of store
  $sql="SELECT mid,SUM(qty) as Qty FROM `grn` WHERE approvedBy is not null ".$curdate." GROUP BY mid";
  $rowSQL= mysqli_query( $con,$sql);
  $effStore=[];
  $totstoreef=0;
  while($row=mysqli_fetch_assoc( $rowSQL )){
    $effStore[sizeof($effStore)]=new efficiency($row['mid']);
    $effStore[sizeof($effStore)-1]->in=$row['Qty'];
  }
  if (isset($_GET['y'])) {
    $sql15="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='store' ".$bbfdate." GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sql15);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($effStore) ; $j++) {
        if ($row['item_no']==$effStore[$j]->itemID) {
          $effStore[$j]->bf+=$row['Qty'];
          continue 2;
        }
      }
        if($row['Qty']!=0){
          $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
            $effStore[sizeof($effStore)-1]->bf=$row['Qty'];
        }
    }
  }
  $sql2="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='store' ".$stockdate." GROUP BY item_no;";
  $rowSQL= mysqli_query( $con,$sql2);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->stock+=$row['Qty'];
        continue 2;
      }
    }
    if($row['Qty']!=0){
        $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
        $effStore[sizeof($effStore)-1]->stock=$row['Qty'];
    }
  }
  $sql3="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='store' AND type='out' ".$curdate." and item_type='material' and approved_by IS NOT null GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql3);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->out+=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
    $effStore[sizeof($effStore)-1]->out=$row['Qty'];
  }
  $sql19="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='store' AND type='return_in' ".$curdate." and item_type='material' and approved_by IS NOT null GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql19);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->in+=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
    $effStore[sizeof($effStore)-1]->in=$row['Qty'];
  }
  $sql20="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='store' AND type='return_out' ".$curdate." and item_type='material' and approved_by IS NOT null GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql20);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->out+=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
    $effStore[sizeof($effStore)-1]->out=$row['Qty'];
  }


    //efficiency of stock transfers between store and production floor
      $rowSQL= mysqli_query( $con,$sql3);
      $effStore_pfloor_transfers=[];
    $totstoretransef=0;
      while($row=mysqli_fetch_assoc( $rowSQL )){
        $effStore_pfloor_transfers[sizeof($effStore_pfloor_transfers)]=new efficiency($row['item_no']);
        $effStore_pfloor_transfers[sizeof($effStore_pfloor_transfers) - 1]->out=$row['Qty'];
      }
      $sql4="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' ".$curdate." AND type='in' and item_type='material' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
      $rowSQL= mysqli_query( $con,$sql4);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        for ($j=0; $j <sizeof($effStore_pfloor_transfers) ; $j++) {
          if ($row['item_no']==$effStore_pfloor_transfers[$j]->itemID) {
            $effStore_pfloor_transfers[$j]->in+=$row['Qty'];
            continue 2;
          }
        }
        $effStore_pfloor_transfers[sizeof($effStore_pfloor_transfers)]= new efficiency($row['item_no']);
        $effStore_pfloor_transfers[sizeof($effStore_pfloor_transfers) - 1]->in=$row['Qty'];
      }

      //efficiency of stock returns between store and production floor
        $rowSQL= mysqli_query( $con,$sql19);
        $effStore_pfloor_returns=[];
      $totstorereturnef=0;
        while($row=mysqli_fetch_assoc( $rowSQL )){
          $effStore_pfloor_returns[sizeof($effStore_pfloor_returns)]=new efficiency($row['item_no']);
          $effStore_pfloor_returns[sizeof($effStore_pfloor_returns) - 1]->in=$row['Qty'];
        }
        $sq21="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' AND type='return_out' and item_type='material' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
        $rowSQL= mysqli_query( $con,$sq21);
        while($row=mysqli_fetch_assoc( $rowSQL )){
          for ($j=0; $j <sizeof($effStore_pfloor_returns) ; $j++) {
            if ($row['item_no']==$effStore_pfloor_returns[$j]->itemID) {
              $effStore_pfloor_returns[$j]->out+=$row['Qty'];
              continue 2;
            }
          }
          $effStore_pfloor_returns[sizeof($effStore_pfloor_returns)]= new efficiency($row['item_no']);
          $effStore_pfloor_returns[sizeof($effStore_pfloor_returns) - 1]->out=$row['Qty'];
        }


    //efficiency of production floor**
    $rowSQL= mysqli_query( $con,$sql4);
    $effpFloor=[];
    $totpflooref=0;
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
      $rowSQL2= mysqli_query( $con,$sql9);
      $row2=mysqli_fetch_array($rowSQL2);
      for ($k=0; $k < sizeof($effpFloor); $k++) {
        if ($effpFloor[$k]->itemID==$row2['Name']) {
          $effpFloor[$k]->in+=$row['Qty'];
          continue 2;
        }
      }
      $effpFloor[sizeof($effpFloor)]=new efficiency($row2['Name'],$row['Qty']);
      $effpFloor[sizeof($effpFloor) - 1]->in=$row['Qty'];
    }
    if (isset($_GET['y'])) {
      $sql15="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='pFloor' ".$bbfdate." GROUP BY item_no";
      $rowSQL= mysqli_query( $con,$sql15);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
        $rowSQL2= mysqli_query( $con,$sql9);
        $row2=mysqli_fetch_array($rowSQL2);
        for ($j=0; $j <sizeof($effpFloor) ; $j++) {
          if ($row2['Name']==$effpFloor[$j]->itemID) {
            $effpFloor[$j]->bf+=$row['Qty'];
            continue 2;
          }
        }
        $effpFloor[sizeof($effpFloor)]= new efficiency($row2['Name']);
        $effpFloor[sizeof($effpFloor) - 1]->bf=$row['Qty'];
      }
      $sql16="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_product' AND dept='pFloor' ".$bbfdate." GROUP BY item_no;";
      $rowSQL= mysqli_query( $con,$sql16);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        $sql12="SELECT bom_id FROM `finished_products` WHERE fp_id=".$row['item_no'];
        $rowSQL2= mysqli_query( $con,$sql12);
        $row2=mysqli_fetch_array($rowSQL2);
        $sql13="SELECT mName,qty FROM `bom` WHERE bom_id=".$row2['bom_id'];
        $rowSQL3= mysqli_query( $con,$sql13);
        while($row3=mysqli_fetch_assoc( $rowSQL3 )){
          for ($j=0; $j <sizeof($effpFloor) ; $j++) {
            if ($row3['mName']==$effpFloor[$j]->itemID) {
              $effpFloor[$j]->bf+=($row['Qty']*$row3['qty']);
              continue 2;
            }
          }
          $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName']);
          $effpFloor[sizeof($effpFloor) - 1]->bf=($row['Qty']*$row3['qty']);
        }
      }
    }
    $sql10="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='pFloor' ".$stockdate."  GROUP BY item_no;";
    $rowSQL= mysqli_query( $con,$sql10);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
      $rowSQL2= mysqli_query( $con,$sql9);
      $row2=mysqli_fetch_array($rowSQL2);
      for ($j=0; $j <sizeof($effpFloor) ; $j++) {
        if ($row2['Name']==$effpFloor[$j]->itemID) {
          $effpFloor[$j]->stock+=$row['Qty'];
          continue 2;
        }
      }
      $effpFloor[sizeof($effpFloor)]= new efficiency($row2['Name']);
      $effpFloor[sizeof($effpFloor) - 1]->stock=$row['Qty'];
    }
    $sql11="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_product' AND dept='pFloor' ".$stockdate." GROUP BY item_no;";
    $rowSQL= mysqli_query( $con,$sql11);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql12="SELECT bom_id FROM `finished_products` WHERE fp_id=".$row['item_no'];
      $rowSQL2= mysqli_query( $con,$sql12);
      $row2=mysqli_fetch_array($rowSQL2);
      $sql13="SELECT mName,qty FROM `bom` WHERE bom_id=".$row2['bom_id'];
      $rowSQL3= mysqli_query( $con,$sql13);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        for ($j=0; $j <sizeof($effpFloor) ; $j++) {
          if ($row3['mName']==$effpFloor[$j]->itemID) {
            $effpFloor[$j]->stock+=($row['Qty']*$row3['qty']);
            continue 2;
          }
        }
        $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName']);
        $effpFloor[sizeof($effpFloor) - 1]->stock=($row['Qty']*$row3['qty']);
      }
    }

    $sql5="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' AND type='out' and item_type='finished_product' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sql5);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql12="SELECT bom_id FROM `finished_products` WHERE fp_id=".$row['item_no'];
      $rowSQL2= mysqli_query( $con,$sql12);
      $row2=mysqli_fetch_array($rowSQL2);
      $sql13="SELECT mName,qty FROM `bom` WHERE bom_id=".$row2['bom_id'];
      $rowSQL3= mysqli_query( $con,$sql13);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        for ($j=0; $j <sizeof($effpFloor) ; $j++) {
          if ($row3['mName']==$effpFloor[$j]->itemID) {
            $effpFloor[$j]->out+=($row['Qty']*$row3['qty']);
            continue 2;
          }
        }
        $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName']);
        $effpFloor[sizeof($effpFloor) - 1]->out=($row['Qty']*$row3['qty']);
      }
    }
    $sq25="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' AND type='return_in' and item_type='finished_product' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sq25);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql12="SELECT bom_id FROM `finished_products` WHERE fp_id=".$row['item_no'];
      $rowSQL2= mysqli_query( $con,$sql12);
      $row2=mysqli_fetch_array($rowSQL2);
      $sql13="SELECT mName,qty FROM `bom` WHERE bom_id=".$row2['bom_id'];
      $rowSQL3= mysqli_query( $con,$sql13);
      while($row3=mysqli_fetch_assoc( $rowSQL3 )){
        for ($j=0; $j <sizeof($effpFloor) ; $j++) {
          if ($row3['mName']==$effpFloor[$j]->itemID) {
            $effpFloor[$j]->in+=($row['Qty']*$row3['qty']);
            continue 2;
          }
        }
        $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName']);
        $effpFloor[sizeof($effpFloor) - 1]->in=($row['Qty']*$row3['qty']);
      }
    }

    $rowSQL= mysqli_query( $con,$sq21);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
      $rowSQL2= mysqli_query( $con,$sql9);
      $row2=mysqli_fetch_array($rowSQL2);
      for ($k=0; $k < sizeof($effpFloor); $k++) {
        if ($effpFloor[$k]->itemID==$row2['Name']) {
          $effpFloor[$k]->out+=$row['Qty'];
          continue 2;
        }
      }
      $effpFloor[sizeof($effpFloor)]=new efficiency($row2['Name'],$row['Qty']);
      $effpFloor[sizeof($effpFloor) - 1]->out=$row['Qty'];
    }
    //efficiency of stock transfers between production floor and finished goods

    $rowSQL= mysqli_query( $con,$sql5);
    $effpfloor_fGoods_transfers=[];
    $totpfloortransef=0;
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $effpfloor_fGoods_transfers[sizeof($effpfloor_fGoods_transfers) ]=new efficiency($row['item_no'],$row['Qty']);
        $effpfloor_fGoods_transfers[sizeof($effpfloor_fGoods_transfers) - 1]->out=$row['Qty'];
    }
    $sql6="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='fGoods' ".$curdate." AND type='in' and item_type='finished_product' and approved_by IS NOT null GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sql6);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($effpfloor_fGoods_transfers) ; $j++) {
        if ($row['item_no']==$effpfloor_fGoods_transfers[$j]->itemID) {
          $effpfloor_fGoods_transfers[$j]->in+=$row['Qty'];
          continue 2;
        }
      }
      $effpfloor_fGoods_transfers[sizeof($effpfloor_fGoods_transfers)]= new efficiency($row['item_no']);
        $effpfloor_fGoods_transfers[sizeof($effpfloor_fGoods_transfers) - 1]->in=$row['Qty'];
    }


    //efficiency of stock returns between production floor and finished goods

    $rowSQL= mysqli_query( $con,$sq25);
    $effpfloor_fGoods_returnss=[];
    $totpfloorreturnsef=0;
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $effpfloor_fGoods_returnss[sizeof($effpfloor_fGoods_returnss) ]=new efficiency($row['item_no'],$row['Qty']);
        $effpfloor_fGoods_returnss[sizeof($effpfloor_fGoods_returnss) - 1]->in=$row['Qty'];
    }
    $sq22="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='fGoods' ".$curdate." AND type='return_out' and item_type='finished_product' and approved_by IS NOT null GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sq22);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($effpfloor_fGoods_returnss) ; $j++) {
        if ($row['item_no']==$effpfloor_fGoods_returnss[$j]->itemID) {
          $effpfloor_fGoods_returnss[$j]->out+=$row['Qty'];
          continue 2;
        }
      }
      $effpfloor_fGoods_returnss[sizeof($effpfloor_fGoods_returnss)]= new efficiency($row['item_no']);
        $effpfloor_fGoods_returnss[sizeof($effpfloor_fGoods_returnss) - 1]->out=$row['Qty'];
    }

    //efficiency of finished goods
    $rowSQL= mysqli_query( $con,$sql6);
    $efffGoods=[];
    $totfgoodsef = 0;
    while($row=mysqli_fetch_assoc( $rowSQL )){
      $efffGoods[sizeof($efffGoods)]=new efficiency($row['item_no'],$row['Qty']);
        $efffGoods[sizeof($efffGoods)-1]->in=$row['Qty'];
    }
    if (isset($_GET['y'])) {
      $sql15="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_product' AND dept='fGoods' ".$bbfdate." GROUP BY item_no";
      $rowSQL= mysqli_query( $con,$sql15);
      while($row=mysqli_fetch_assoc( $rowSQL )){
        for ($j=0; $j <sizeof($efffGoods) ; $j++) {
          if ($row['item_no']==$efffGoods[$j]->itemID) {
            $efffGoods[$j]->bf+=$row['Qty'];
            continue 2;
          }
        }
        $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no']);
          $efffGoods[sizeof($efffGoods)-1]->bf=$row['Qty'];
      }
    }
    $sql7="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_product' ".$stockdate." AND dept='fGoods' GROUP BY item_no;";
    $rowSQL= mysqli_query( $con,$sql7);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($efffGoods) ; $j++) {
        if ($row['item_no']==$efffGoods[$j]->itemID) {
          $efffGoods[$j]->stock+=$row['Qty'];
          continue 2;
        }
      }
      $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no']);
        $efffGoods[sizeof($efffGoods)-1]->stock=$row['Qty'];
    }
    $sql8="SELECT item_no,SUM(qty) AS Qty from invoice WHERE approved_by IS NOT null ".$curdate." GROUP BY item_no;";
    $rowSQL= mysqli_query( $con,$sql8);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($efffGoods) ; $j++) {
        if ($row['item_no']==$efffGoods[$j]->itemID) {
          $efffGoods[$j]->out+=$row['Qty'];
          continue 2;
        }
      }
      $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],$row['Qty']);
      $efffGoods[sizeof($efffGoods)-1]->out=$row['Qty'];
    }

    $rowSQL= mysqli_query( $con,$sq22);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($efffGoods) ; $j++) {
        if ($row['item_no']==$efffGoods[$j]->itemID) {
          $efffGoods[$j]->out+=$row['Qty'];
          continue 2;
        }
      }
      $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],$row['Qty']);
      $efffGoods[sizeof($efffGoods)-1]->out=$row['Qty'];
    }

    $sq23="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='fGoods' ".$curdate." AND type='return_in' and item_type='finished_product' and approved_by IS NOT null GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sq22);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($efffGoods) ; $j++) {
        if ($row['item_no']==$efffGoods[$j]->itemID) {
          $efffGoods[$j]->in+=$row['Qty'];
          continue 2;
        }
      }
      $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],$row['Qty']);
      $efffGoods[sizeof($efffGoods)-1]->in=$row['Qty'];
    }


    mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/efStyles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <title>viewEfficiency</title>
  </head>
  <body>
    <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <!--<div class="btn-navi"><i class="ion-navicon-round"></i></div>-->
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="selectEf.php">
                    <div class="btn-back"><i class="ion-ios-arrow-back"></i><p>Back</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="userProfile.php"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class="section-view">
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effStore)>0){
                        for ($j=0; $j <sizeof($effStore) ; $j++) {
                        $effStore[$j]->dif=($effStore[$j]->in + $effStore[$j]->bf) - ($effStore[$j]->stock + $effStore[$j]->out);
                        if(($effStore[$j]->in + $effStore[$j]->bf)==0 && ($effStore[$j]->stock + $effStore[$j]->out)==0){
                            $effStore[$j]->eff=1;
                        }elseif(($effStore[$j]->in + $effStore[$j]->bf)==0 || ($effStore[$j]->stock + $effStore[$j]->out)==0){
                            $effStore[$j]->eff=0;
                        }else{
                            $effStore[$j]->eff=($effStore[$j]->in + $effStore[$j]->bf) / ($effStore[$j]->stock + $effStore[$j]->out);
                        }
                        $totstoreef+=$effStore[$j]->eff;
                        }
                        if($totstoreef>0){
                            $class= efClass($totstoreef/sizeof($effStore));
                            echo "Efficiency of Store =<span class=".$class."><strong>".round($totstoreef/sizeof($effStore)*100,2)."%</strong></span><br>";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of Store =<span class=".$class."><strong>0%</strong></span><br>";
                        }
                    }else{
                        echo "No Recorded Operations ";
                    }
                    echo $dateDisplay;
                ?>
            </div>
            <div class="col span-1-of-2">
                    <?php
                        if(sizeof($effStore)>0){
                            echo "<table>
                                    <thead>
                                        <th>Material No</th><th>IN</th><th>Balance Stock Brought Forward</th><th>In Stock</th><th>OUT</th><th>Difference</th><th>Meterial Efficiency</th>
                                    </thead>";
                            for ($j=0; $j <sizeof($effStore) ; $j++) {
                              $class = efClass($effStore[$j]->eff);
                              echo "
                              <tr>
                                <td class=".$class."><strong>".$effStore[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$effStore[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$effStore[$j]->bf."</strong></td>
                                <td class=".$class."><strong>".$effStore[$j]->stock."</strong></td>
                                <td class=".$class."><strong>".$effStore[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$effStore[$j]->dif."</strong></td>
                                <td class=".$class."><strong>".round($effStore[$j]->eff,2)."</strong></td>
                            </tr>";
                           }
                            echo "</table>";
                        }else{
                            echo "No Recorded Operations ".$dateDisplay;
                        }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effStore_pfloor_transfers)>0){
                        for ($j=0; $j <sizeof($effStore_pfloor_transfers) ; $j++) {
                            $effStore_pfloor_transfers[$j]->dif=$effStore_pfloor_transfers[$j]->out - $effStore_pfloor_transfers[$j]->in;
                            if($effStore_pfloor_transfers[$j]->out==0 && $effStore_pfloor_transfers[$j]->in==0){
                                $effStore_pfloor_transfers[$j]->eff=1;
                            }elseif($effStore_pfloor_transfers[$j]->out==0 || $effStore_pfloor_transfers[$j]->in==0){
                                $effStore_pfloor_transfers[$j]->eff=0;
                            }else{
                                $effStore_pfloor_transfers[$j]->eff= $effStore_pfloor_transfers[$j]->out / $effStore_pfloor_transfers[$j]->in;
                            }
                            $totstoretransef+=$effStore_pfloor_transfers[$j]->eff;
                        }
                        if($totstoretransef>0){
                            $class= efClass($totstoretransef/sizeof($effStore_pfloor_transfers));
                            echo "Efficiency of Store transfers =<span class=".$class."><strong>".round($totstoretransef/sizeof($effStore_pfloor_transfers)*100,2)."%</strong></span><br>";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of Store transfers =<span class=".$class."><strong>0%</strong></span><br>";
                        }
                        echo $dateDisplay;
                    }else{
                        echo "No transfers between store and pfloor ".$dateDisplay;
                    }
                ?>
            </div>
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effStore_pfloor_transfers)>0){
                        echo "
                        <table>
                            <thead>
                                <th>Material No</th><th>Store OUT</th><th>PFloor IN</th><th>Difference</th><th>Transfer Efficiency</th>
                            </thead>";
                        for ($j=0; $j <sizeof($effStore_pfloor_transfers) ; $j++) {
                            $class = efClass($effStore_pfloor_transfers[$j]->eff);
                            echo "<tr>
                                <td class=".$class."><strong>".$effStore_pfloor_transfers[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_transfers[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_transfers[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_transfers[$j]->dif. "</strong></td>
                                <td class=".$class."><strong>".round($effStore_pfloor_transfers[$j]->eff,2)."</strong></td>
                            </tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "No transfers between store and pfloor ".$dateDisplay;
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effStore_pfloor_returns)>0){
                        for ($j=0; $j <sizeof($effStore_pfloor_returns) ; $j++) {
                            $effStore_pfloor_returns[$j]->dif=$effStore_pfloor_returns[$j]->out - $effStore_pfloor_returns[$j]->in;
                            if(($effStore_pfloor_returns[$j]->out==0 && $effStore_pfloor_returns[$j]->in==0)){
                                $effStore_pfloor_returns[$j]->eff=1;
                            }elseif($effStore_pfloor_returns[$j]->out==0 || $effStore_pfloor_returns[$j]->in==0){
                                $effStore_pfloor_returns[$j]->eff=0;
                            }else{
                                $effStore_pfloor_returns[$j]->eff= $effStore_pfloor_returns[$j]->out / $effStore_pfloor_returns[$j]->in;
                            }
                            $totstorereturnef+=$effStore_pfloor_returns[$j]->eff;
                        }
                        if($totstorereturnef>0){
                            $class= efClass($totstorereturnef/sizeof($effStore_pfloor_returns));
                            echo "Efficiency of pfloor returns =<span class=".$class."><strong>".round($totstorereturnef/sizeof($effStore_pfloor_returns)*100,2)."%</strong></span><br>";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of pfloor returns =<span class=".$class."><strong>0%</strong></span><br>";
                        }
                        echo $dateDisplay;
                    }else{
                        echo "No Returns between store and pfloor ".$dateDisplay;
                    }
                ?>
            </div>
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effStore_pfloor_returns)>0){
                        echo "
                        <table>
                            <thead>
                                <th>Material No</th><th>Store in</th><th>PFloor out</th><th>Difference</th><th>Transfer Efficiency</th>
                            </thead>";
                        for ($j=0; $j <sizeof($effStore_pfloor_returns) ; $j++) {
                            $class = efClass($effStore_pfloor_returns[$j]->eff);
                            echo "<tr>
                                <td class=".$class."><strong>".$effStore_pfloor_returns[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_returns[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_returns[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$effStore_pfloor_returns[$j]->dif. "</strong></td>
                                <td class=".$class."><strong>".round($effStore_pfloor_returns[$j]->eff,2)."</strong></td>
                            </tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "No returns between store and pfloor ".$dateDisplay;
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                    <?php
                        if(sizeof($effpFloor)>0){
                            for ($j=0; $j <sizeof($effpFloor) ; $j++) {
                            $effpFloor[$j]->dif=($effpFloor[$j]->in + $effpFloor[$j]->bf) - ($effpFloor[$j]->stock + $effpFloor[$j]->out);
                            if(($effpFloor[$j]->in + $effpFloor[$j]->bf)==0 && ($effpFloor[$j]->stock + $effpFloor[$j]->out)==0){
                                $effpFloor[$j]->eff=1;
                            }elseif(($effpFloor[$j]->in + $effpFloor[$j]->bf)==0 || ($effpFloor[$j]->stock + $effpFloor[$j]->out)==0){
                                $effpFloor[$j]->eff=0;
                            }else{
                                $effpFloor[$j]->eff= ($effpFloor[$j]->in + $effpFloor[$j]->bf)/ ($effpFloor[$j]->stock + $effpFloor[$j]->out);
                            }
                            $totpflooref+=$effpFloor[$j]->eff;
                        }
                        if($totpflooref>0){
                            $class= efClass($totpflooref/sizeof($effpFloor));
                            echo "Efficiency of Production Floor =<span class=".$class."><strong>".round($totpflooref/sizeof($effpFloor)*100,2)."%</strong></span><br>";
                            echo $dateDisplay;
                            echo "<br>(Calculated by converting finished products using their BOMs)";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of Production Floor =<span class=".$class."><strong>0%</strong></span><br>";
                            echo $dateDisplay;
                        }
                        }else{
                            echo "No Recorded Operations ";
                            echo $dateDisplay;
                        }
                    ?>
            </div>
            <div class="col span-1-of-2">
                    <?php
                        if(sizeof($effpFloor)>0){
                            echo "<table>
                                    <thead>
                                        <th>Material Name</th><th>IN</th><th>Balance Stock Brought Forward</th><th>In Stock</th><th>OUT</th><th>Difference</th><th>Meterial Efficiency</th>
                                    </thead>";
                            for ($j=0; $j <sizeof($effpFloor) ; $j++) {
                            $class = efClass($effpFloor[$j]->eff);
                            echo "<tr>
                                    <td class=".$class."><strong>".$effpFloor[$j]->itemID."</strong></td>
                                    <td class=".$class."><strong>".$effpFloor[$j]->in."</strong></td>
                                    <td class=".$class."><strong>".$effpFloor[$j]->bf."</strong></td>
                                    <td class=".$class."><strong>".$effpFloor[$j]->stock."</strong></td>
                                    <td class=".$class."><strong>".$effpFloor[$j]->out."</strong></td>
                                    <td class=".$class."><strong>".$effpFloor[$j]->dif. "</strong></td>
                                    <td class=".$class."><strong>".round($effpFloor[$j]->eff,2)."</strong></td>
                                </tr>";
                            }
                            echo "</table>";
                          }else{
                            echo "No Recorded Operations ".$dateDisplay;
                        }
                    ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effpfloor_fGoods_transfers)>0){
                        for ($j=0; $j <sizeof($effpfloor_fGoods_transfers) ; $j++) {
                            $effpfloor_fGoods_transfers[$j]->dif=$effpfloor_fGoods_transfers[$j]->out - $effpfloor_fGoods_transfers[$j]->in;
                            if($effpfloor_fGoods_transfers[$j]->out==0 && $effpfloor_fGoods_transfers[$j]->in==0){
                                $effpfloor_fGoods_transfers[$j]->eff=1;
                            }elseif($effpfloor_fGoods_transfers[$j]->out==0 || $effpfloor_fGoods_transfers[$j]->in==0){
                                $effpfloor_fGoods_transfers[$j]->eff=0;
                            }else{
                                $effpfloor_fGoods_transfers[$j]->eff= $effpfloor_fGoods_transfers[$j]->out / $effpfloor_fGoods_transfers[$j]->in;
                            }
                            $totpfloortransef+=$effpfloor_fGoods_transfers[$j]->eff;
                        }
                        if($totpfloortransef>0){
                            $class= efClass($totpfloortransef/sizeof($effpfloor_fGoods_transfers));
                            echo "Efficiency of Production Floor transfers =<span class=".$class."><strong>".round($totpfloortransef/sizeof($effpfloor_fGoods_transfers)*100,2)."%</strong></span><br>";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of Production Floor transfers =<span class=".$class."><strong>0%</strong></span><br>";
                        }
                        
                        echo $dateDisplay;
                    }else{
                        echo "No transfers between pfloor and fgoods ".$dateDisplay;
                    }
                ?>
            </div>
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effpfloor_fGoods_transfers)>0){
                        echo "
                        <table>
                            <thead>
                                <th>Finished Product No</th><th>Store OUT</th><th>PFloor IN</th><th>Difference</th><th>Transfer Efficiency</th>
                            </thead>";
                        for ($j=0; $j <sizeof($effpfloor_fGoods_transfers) ; $j++) {
                            $class = efClass($effpfloor_fGoods_transfers[$j]->eff);
                            echo "<tr>
                                <td class=".$class."><strong>".$effpfloor_fGoods_transfers[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_transfers[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_transfers[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_transfers[$j]->dif. "</strong></td>
                                <td class=".$class."><strong>".round($effpfloor_fGoods_transfers[$j]->eff,2)."</strong></td>
                            </tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "No transfers between pfloor and fgoods ".$dateDisplay;
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effpfloor_fGoods_returnss)>0){
                        for ($j=0; $j <sizeof($effpfloor_fGoods_returnss) ; $j++) {
                            $effpfloor_fGoods_returnss[$j]->dif=$effpfloor_fGoods_returnss[$j]->out - $effpfloor_fGoods_returnss[$j]->in;
                            if($effpfloor_fGoods_returnss[$j]->out==0 && $effpfloor_fGoods_returnss[$j]->in==0){
                                $effpfloor_fGoods_returnss[$j]->eff=1;
                            }elseif($effpfloor_fGoods_returnss[$j]->out==0 || $effpfloor_fGoods_returnss[$j]->in==0){
                                $effpfloor_fGoods_returnss[$j]->eff=0;
                            }else{
                                $effpfloor_fGoods_returnss[$j]->eff= $effpfloor_fGoods_returnss[$j]->out / $effpfloor_fGoods_returnss[$j]->in;
                            }
                            $totpfloorreturnsef+=$effpfloor_fGoods_returnss[$j]->eff;
                        }
                        if($totpfloorreturnsef>0){
                            $class= efClass($totpfloorreturnsef/sizeof($effpfloor_fGoods_returnss));
                            echo "Efficiency of fgoods returns =<span class=".$class."><strong>".round($totpfloorreturnsef/sizeof($effpfloor_fGoods_returnss)*100,2)."%</strong></span><br>";
                        }else{
                            $class= efClass(0);
                            echo "Efficiency of fgoods returns =<span class=".$class."><strong>0%</strong></span><br>";
                        }
                        echo $dateDisplay;
                    }else{
                        echo "No Returns between pfloor and fgoods ".$dateDisplay;
                    }
                ?>
            </div>
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($effpfloor_fGoods_returnss)>0){
                        echo "
                        <table>
                            <thead>
                                <th>Finished Product No</th><th>pfloor in</th><th>fgoods out</th><th>Difference</th><th>Transfer Efficiency</th>
                            </thead>";
                        for ($j=0; $j <sizeof($effpfloor_fGoods_returnss) ; $j++) {
                            $class = efClass($effpfloor_fGoods_returnss[$j]->eff);
                            echo "<tr>
                                <td class=".$class."><strong>".$effpfloor_fGoods_returnss[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_returnss[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_returnss[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$effpfloor_fGoods_returnss[$j]->dif. "</strong></td>
                                <td class=".$class."><strong>".round($effpfloor_fGoods_returnss[$j]->eff,2)."</strong></td>
                            </tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "No returns between pfloor and fgoods ".$dateDisplay;
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col span-1-of-2">
                <?php
                    if(sizeof($efffGoods)>0){
                        for ($j=0; $j <sizeof($efffGoods) ; $j++) {
                        $efffGoods[$j]->dif=$efffGoods[$j]->in + $efffGoods[$j]->bf - $efffGoods[$j]->stock - $efffGoods[$j]->out;
                        if(($efffGoods[$j]->in + $efffGoods[$j]->bf)==0 && ($efffGoods[$j]->stock + $efffGoods[$j]->out)==0){
                            $efffGoods[$j]->eff=1;
                        }elseif(($efffGoods[$j]->in + $efffGoods[$j]->bf)==0 || ($efffGoods[$j]->stock + $efffGoods[$j]->out)==0){
                            $efffGoods[$j]->eff=0;
                        }else{
                            $efffGoods[$j]->eff=($efffGoods[$j]->in + $efffGoods[$j]->bf) / ($efffGoods[$j]->stock + $efffGoods[$j]->out);
                        }
                        $totfgoodsef+=$efffGoods[$j]->eff;
                    }
                    if($totfgoodsef>0){
                        $class= efClass($totfgoodsef/sizeof($efffGoods));
                        echo "Efficiency of Finished Goods =<span class=".$class."><strong>".round($totfgoodsef/sizeof($efffGoods)*100,2)."%</span></strong><br>";
                    }else{
                        $class= efClass(0);
                        echo "Efficiency of Finished Goods =<span class=".$class."><strong>0%</span></strong><br>";
                    }
                    }else{
                        echo "No Recorded Operations ";
                    }
                    
                    echo $dateDisplay;
                ?>
            </div>
            <div class="col span-1-of-2">
                    <?php
                        if(sizeof($efffGoods)>0){
                            echo "<table>
                                    <thead>
                                        <th>Finished Product No</th><th>IN</th><th>Balance Stock Brought Forward</th><th>In Stock</th><th>OUT</th><th>Difference</th><th>Meterial Efficiency</th>
                                    </thead>";
                            for ($j=0; $j <sizeof($efffGoods) ; $j++) {
                                $class = efClass($efffGoods[$j]->eff);
                              echo "
                              <tr>
                                <td class=".$class."><strong>".$efffGoods[$j]->itemID."</strong></td>
                                <td class=".$class."><strong>".$efffGoods[$j]->in."</strong></td>
                                <td class=".$class."><strong>".$efffGoods[$j]->bf."</strong></td>
                                <td class=".$class."><strong>".$efffGoods[$j]->stock."</strong></td>
                                <td class=".$class."><strong>".$efffGoods[$j]->out."</strong></td>
                                <td class=".$class."><strong>".$efffGoods[$j]->dif."</strong></td>
                                <td class=".$class."><strong>".round($efffGoods[$j]->eff,2)."</strong></td>
                            </tr>";
                            }
                           echo "</table>";
                        }else{
                            echo "No Recorded Operations ".$dateDisplay;
                        }
                ?>
            </div>
        </div>
    </section>
    <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
  </body>
</html>
<!--dan-->
