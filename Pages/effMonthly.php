<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
  }
  class efficiency{

    public $itemID;
    public $qty;

    function __construct($itemID,$qty){
      $this->itemID = $itemID;
      $this->qty = $qty;
    }
  }
  $bbfdate="";
  $curdate="";
  $stockdate="";
  if (isset($_GET['y'])&&isset($_GET['m'])) {
    $bbfdate="AND date<'".$_GET['y']."-".$_GET['m']."-01'";
    $stockdate="AND date<='".$_GET['y']."-".($_GET['m']+1)."-01'";
    $curdate="AND extract(year from date)=".$_GET['y']." and extract(month from date)=".$_GET['m']."";
  }elseif (isset($_GET['y'])&&!isset($_GET['m'])) {
    $bbfdate="AND date<'".$_GET['y']."-01-01'";
    $stockdate="AND date<='".($_GET['y']+1)."-01-01'";
    $curdate="AND extract(year from date)=".$_GET['y'];
  }

  $con=mysqli_connect("localhost","root","","galleon_lanka");
  if(!$con){
    die("Cannot connect to DB server");
  }
  //efficiency of store
  $sql="SELECT mid,SUM(qty) as Qty FROM `grn` WHERE approvedBy is not null ".$curdate." GROUP BY mid";
  $rowSQL= mysqli_query( $con,$sql);
  $effStore=[];
  $i=0;
  $storein=0;
  while($row=mysqli_fetch_assoc( $rowSQL )){
    $effStore[$i++]=new efficiency($row['mid'],$row['Qty']);
    $storein+=$row['Qty'];
  }
  if (isset($_GET['y'])) {
    $sql15="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='store' ".$bbfdate." GROUP BY item_no";
    $rowSQL= mysqli_query( $con,$sql15);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($effStore) ; $j++) {
        if ($row['item_no']==$effStore[$j]->itemID) {
          $effStore[$j]->qty+=$row['Qty'];
          $storein+=$row['Qty'];
          continue 2;
        }
      }
      $effStore[sizeof($effStore)]= new efficiency($row['item_no'],$row['Qty']);
      $storein+=$row['Qty'];
    }
  }
  $sql2="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='store' ".$stockdate." GROUP BY item_no;";
  $rowSQL= mysqli_query( $con,$sql2);
  $storeout=0;
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->qty-=$row['Qty'];
        $storeout+=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no'],-$row['Qty']);
    $storeout+=$row['Qty'];
  }
  $sql3="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='store' AND type='out' ".$curdate." and item_type='material' and approved_by IS NOT null GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql3);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore) ; $j++) {
      if ($row['item_no']==$effStore[$j]->itemID) {
        $effStore[$j]->qty-=$row['Qty'];
        $storeout+=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no'],-$row['Qty']);
    $storeout+=$row['Qty'];
  }

  //efficiency of stock transfers between store and production floor
  $rowSQL= mysqli_query( $con,$sql3);
  $effStore_pfloor_transfers=[];
  $i=0;
  $storeTransferOut=0;
  while($row=mysqli_fetch_assoc( $rowSQL )){
    $effStore_pfloor_transfers[$i++]=new efficiency($row['item_no'],$row['Qty']);
    $storeTransferOut+=$row['Qty'];
  }
  $sql4="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' ".$curdate." AND type='in' and item_type='material' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql4);
  $pfloorTransferIn=0;
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($effStore_pfloor_transfers) ; $j++) {
      if ($row['item_no']==$effStore_pfloor_transfers[$j]->itemID) {
        $effStore_pfloor_transfers[$j]->qty-=$row['Qty'];
        $pfloorTransferIn+=$row['Qty'];
        continue 2;
      }
    }
    $effStore_pfloor_transfers[sizeof($effStore_pfloor_transfers)]= new efficiency($row['item_no'],-$row['Qty']);
    $pfloorTransferIn+=$row['Qty'];
  }
//
//efficiency of stock transfers between production floor and finished goods

$sql5="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='pFloor' ".$curdate." AND type='out' and item_type='finished_product' ".$curdate." and approved_by IS NOT null GROUP BY item_no";
$rowSQL= mysqli_query( $con,$sql5);
$i=0;
$pfloorTransferOut=0;
$effpfloor_fGoods_transfers=[];
while($row=mysqli_fetch_assoc( $rowSQL )){
  $effpfloor_fGoods_transfers[$i++]=new efficiency($row['item_no'],$row['Qty']);
  $pfloorTransferOut+=$row['Qty'];
}
$sql6="SELECT item_no,SUM(qty) AS Qty FROM `gtn` WHERE dept='fGoods' ".$curdate." AND type='in' and item_type='finished_product' and approved_by IS NOT null GROUP BY item_no";
$rowSQL= mysqli_query( $con,$sql6);
$gGoodsTransferIn=0;
while($row=mysqli_fetch_assoc( $rowSQL )){
  for ($j=0; $j <sizeof($effpfloor_fGoods_transfers) ; $j++) {
    if ($row['item_no']==$effpfloor_fGoods_transfers[$j]->itemID) {
      $effpfloor_fGoods_transfers[$j]->qty-=$row['Qty'];
      $gGoodsTransferIn+=$row['Qty'];
      continue 2;
    }
  }
  $effpfloor_fGoods_transfers[sizeof($effpfloor_fGoods_transfers)]= new efficiency($row['item_no'],-$row['Qty']);
  $gGoodsTransferIn+=$row['Qty'];
}


//efficiency of finished goods
$rowSQL= mysqli_query( $con,$sql6);
$gGoodsIn=0;
$efffGoods=[];
$i=0;
while($row=mysqli_fetch_assoc( $rowSQL )){
  $efffGoods[$i++]=new efficiency($row['item_no'],$row['Qty']);
  $gGoodsIn+=$row['Qty'];
}
if (isset($_GET['y'])) {
  $sql15="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_products' AND dept='fGoods' ".$bbfdate." GROUP BY item_no";
  $rowSQL= mysqli_query( $con,$sql15);
  while($row=mysqli_fetch_assoc( $rowSQL )){
    for ($j=0; $j <sizeof($efffGoods) ; $j++) {
      if ($row['item_no']==$efffGoods[$j]->itemID) {
        $efffGoods[$j]->qty+=$row['Qty'];
        $gGoodsIn+=$row['Qty'];
        continue 2;
      }
    }
    $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],$row['Qty']);
    $gGoodsIn+=$row['Qty'];
  }
}
$sql7="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='finished_product' ".$stockdate." AND dept='fGoods' GROUP BY item_no;";
$rowSQL= mysqli_query( $con,$sql7);
$fgoodsout=0;
while($row=mysqli_fetch_assoc( $rowSQL )){
  for ($j=0; $j <sizeof($efffGoods) ; $j++) {
    if ($row['item_no']==$efffGoods[$j]->itemID) {
      $efffGoods[$j]->qty-=$row['Qty'];
      $fgoodsout+=$row['Qty'];
      continue 2;
    }
  }
  $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],-$row['Qty']);
  $fgoodsout+=$row['Qty'];
}
$sql8="SELECT item_no,SUM(qty) AS Qty from invoice WHERE approved_by IS NOT null ".$curdate." GROUP BY item_no;";
$rowSQL= mysqli_query( $con,$sql8);
while($row=mysqli_fetch_assoc( $rowSQL )){
  for ($j=0; $j <sizeof($efffGoods) ; $j++) {
    if ($row['item_no']==$efffGoods[$j]->itemID) {
      $efffGoods[$j]->qty-=$row['Qty'];
      $fgoodsout+=$row['Qty'];
      continue 2;
    }
  }
  $efffGoods[sizeof($efffGoods)]= new efficiency($row['item_no'],-$row['Qty']);
  $fgoodsout+=$row['Qty'];
}

//efficiency of production floor**
$rowSQL= mysqli_query( $con,$sql4);
$pFloorIn=0;
$effpFloor=[];
$i=0;
while($row=mysqli_fetch_assoc( $rowSQL )){
  $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
  $rowSQL2= mysqli_query( $con,$sql9);
  $row2=mysqli_fetch_array($rowSQL2);
  for ($k=0; $k < sizeof($effpFloor); $k++) {
    if ($effpFloor[$k]->itemID==$row2['Name']) {
      $effpFloor[$k]->qty+=$row['Qty'];
      $pFloorIn+=$row['Qty'];
      continue 2;
    }
  }
  $effpFloor[$i++]=new efficiency($row2['Name'],$row['Qty']);
  $pFloorIn+=$row['Qty'];
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
        $effpFloor[$j]->qty+=$row['Qty'];
        $pFloorIn+=$row['Qty'];
        continue 2;
      }
    }
    $effpFloor[sizeof($effpFloor)]= new efficiency($row2['Name'],$row['Qty']);
    $pFloorIn+=$row['Qty'];
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
          $effpFloor[$j]->qty+=($row['Qty']*$row3['qty']);
          $pFloorIn+=($row['Qty']*$row3['qty']);
          continue 2;
        }
      }
      $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName'],($row['Qty']*$row3['qty']));
      $pFloorIn+=($row['Qty']*$row3['qty']);
    }
  }
}
$sql10="SELECT item_no,SUM(qty) AS Qty from stocks WHERE type='material' AND dept='pFloor' ".$stockdate."  GROUP BY item_no;";
$rowSQL= mysqli_query( $con,$sql10);
$pFloorout=0;
while($row=mysqli_fetch_assoc( $rowSQL )){
  $sql9="SELECT Name FROM `materials` WHERE mid=".$row['item_no']."";
  $rowSQL2= mysqli_query( $con,$sql9);
  $row2=mysqli_fetch_array($rowSQL2);
  for ($j=0; $j <sizeof($effpFloor) ; $j++) {
    if ($row2['Name']==$effpFloor[$j]->itemID) {
      $effpFloor[$j]->qty-=$row['Qty'];
      $pFloorout+=$row['Qty'];
      continue 2;
    }
  }
  $effpFloor[sizeof($effpFloor)]= new efficiency($row2['Name'],-$row['Qty']);
  $pFloorout+=$row['Qty'];
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
        $effpFloor[$j]->qty-=($row['Qty']*$row3['qty']);
        $pFloorout+=($row['Qty']*$row3['qty']);
        continue 2;
      }
    }
    $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName'],-($row['Qty']*$row3['qty']));
    $pFloorout+=($row['Qty']*$row3['qty']);
  }
}
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
        $effpFloor[$j]->qty-=($row['Qty']*$row3['qty']);
        $pFloorout+=($row['Qty']*$row3['qty']);
        continue 2;
      }
    }
    $effpFloor[sizeof($effpFloor)]= new efficiency($row3['mName'],-($row['Qty']*$row3['qty']));
    $pFloorout+=($row['Qty']*$row3['qty']);
  }
}

  mysqli_close($con);

  echo "Efficiency of Store =".round($storeout/$storein*100,2)."% <br>";
  echo "Efficiency of stock transfers between Store and Production Floor=".round($pfloorTransferIn/$storeTransferOut*100,2)."% <br>";
  echo "Efficiency of Production Floor =".round($pFloorout/$pFloorIn*100,2)."% <br>";
  echo "Efficiency of stock transfers between Production Floor and Finished goods=".round($gGoodsTransferIn/$pfloorTransferOut*100,2)."% <br>";
  echo "Efficiency of Finished Goods =".round($fgoodsout/$gGoodsIn*100,2)."% <br>";

?>
<!--dan-->
