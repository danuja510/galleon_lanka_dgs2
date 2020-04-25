<?php
  session_start();
  if(!isset($_SESSION['eno'])){
    header('Location:signIn.php');
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
          $effStore[$j]->bf=$row['Qty'];
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
        $effStore[$j]->stock=$row['Qty'];
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
        $effStore[$j]->out=$row['Qty'];
        continue 2;
      }
    }
    $effStore[sizeof($effStore)]= new efficiency($row['item_no']);
    $effStore[sizeof($effStore)-1]->out=$row['Qty'];
  }
mysqli_close($con);

    for ($j=0; $j <sizeof($effStore) ; $j++) {
        $effStore[$j]->dif=$effStore[$j]->in + $effStore[$j]->bf - $effStore[$j]->stock - $effStore[$j]->out;
        $effStore[$j]->eff=($effStore[$j]->stock + $effStore[$j]->out) / ($effStore[$j]->in + $effStore[$j]->bf);
        $totstoreef+=$effStore[$j]->eff;
    }
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
                <div class="btn-navi"><i class="ion-navicon-round"></i></div>
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="#"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section class="section-view">
    <?php
      echo "Efficiency of Store =".round($totstoreef/sizeof($effStore)*100,2)."% <br>";
        /*
      echo "Efficiency of stock transfers between Store and Production Floor=".round($pfloorTransferIn/$storeTransferOut*100,2)."% <br>";
      echo "Efficiency of Production Floor =".round($pFloorout/$pFloorIn*100,2)."% <br>";
      echo "Efficiency of stock transfers between Production Floor and Finished goods=".round($gGoodsTransferIn/$pfloorTransferOut*100,2)."% <br>";
      echo "Efficiency of Finished Goods =".round($fgoodsout/$gGoodsIn*100,2)."% <br>";*/
      for ($j=0; $j <sizeof($effStore) ; $j++) {
          echo "item ".$effStore[$j]->itemID." in- ".$effStore[$j]->in." bf-  ".$effStore[$j]->bf." stock-  ".$effStore[$j]->stock." out-  ".$effStore[$j]->out."  dif- ".$effStore[$j]->dif. "  ef=  ".$effStore[$j]->eff."<br>";
      }  
    ?>
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
