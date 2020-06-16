<?php
  require '../Database/db.php';

  class Stock
  {
    public $item_name;
    public $dept;
    public $type;
    public $qty;

    function __construct($item_name,$qty, $type, $dept)
    {
      $this->item_name=$item_name;
      $this->dept=$dept;
      $this->type=$type;
      $this->qty=$qty;
    }
  }

  function previous_month()
  {
    $date["year"] = date("Y");
    $date["month"] = date("m")-1;
    if ($date["month"] == 0) {
      $date["year"]--;
      $date["month"]= 12;
    }
    return $date;
  }


  function viewStocksEmployee($dep)
  {
    return getCurrentStock($dept="  and `dept`='".$dep."' ");
  }

  function viewStocksManager()
  {
    return getCurrentStock($dept="");
  }

  function viewStocksManagerFiltered($sort)
  {
    return getCurrentStock($dept=" and `dept`='".$sort."' ");
  }

  function getCurrentStock($dept){
    $con = create_connection();

    $date=previous_month();

    $sql="SELECT dept,item_name,type,qty,date
          FROM `balance_stocks`
          where extract(month from date)= '".$date["month"]."'
          and extract(year from date)= '".$date["year"]."'
          ".$dept."
          ;";
    $stockArr=[];
    $rowSQL= mysqli_query($con,$sql);
    while ($row = mysqli_fetch_assoc($rowSQL)) {
      if ($row['qty']!=0){
        $stockArr[sizeof($stockArr)]= new Stock($row['item_name'], $row['qty'], $row['type'], $row['dept']);
      }
    }

    if ($dept!="") {
      $sql="SELECT MAX(date) as pdate FROM `balance_stocks` WHERE date < '".date("Y")."-".date("m")."-01' ".$dept.";";
      $rowSQL= mysqli_query($con,$sql);
      if(mysqli_num_rows($rowSQL)>0){
        $pdate=mysqli_fetch_array($rowSQL);
        $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
              FROM `stocks`
              where date > '".$pdate['pdate']."'
              ".$dept."
              GROUP BY dept, item_name, type;";
      }else{
        $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
              FROM `stocks`
              where extract(month from date)= extract(month from NOW())
              and extract(year from date)= extract(year from NOW())
              ".$dept."
              GROUP BY dept, item_name, type;";
      }
      $rowSQL= mysqli_query($con,$sql);
      while ($row = mysqli_fetch_assoc($rowSQL)) {
        foreach ($stockArr as $stock) {
          if ($stock->item_name==$row['item_name'] && $stock->dept==$row['dept']) {
            $stock->qty+=$row['finalstock'];
            continue 2;
          }
        }
        if ($row['finalstock']!=0) {
          $stockArr[sizeof($stockArr)]= new Stock($row['item_name'], $row['finalstock'], $row['type'], $row['dept']);
        }
      }
    }else{
      $depts=['store', 'pFloor', 'fGoods'];
      foreach ($depts as $d) {
        $sql="SELECT MAX(date) as pdate FROM `balance_stocks` WHERE date < '".date("Y")."-".date("m")."-01' and `dept`='".$d."';";
        $rowSQL= mysqli_query($con,$sql);
        if(mysqli_num_rows($rowSQL)>0){
          $pdate=mysqli_fetch_array($rowSQL);
          $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
                FROM `stocks`
                where date > '".$pdate['pdate']."'
                and `dept`='".$d."'
                GROUP BY dept, item_name, type;";
        }else{
          $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
                FROM `stocks`
                where extract(month from date)= extract(month from NOW())
                and extract(year from date)= extract(year from NOW())
                and `dept`='".$d."'
                GROUP BY dept, item_name, type;";
        }
        $rowSQL= mysqli_query($con,$sql);
        while ($row = mysqli_fetch_assoc($rowSQL)) {
          foreach ($stockArr as $stock) {
            if ($stock->item_name==$row['item_name'] && $stock->dept==$row['dept']) {
              $stock->qty+=$row['finalstock'];
              continue 2;
            }
          }
          if ($row['finalstock']!=0) {
            $stockArr[sizeof($stockArr)]= new Stock($row['item_name'], $row['finalstock'], $row['type'], $row['dept']);
          }
        }
      }
    }

    $sql="SELECT dept,item_name,type,qty,date
          FROM `balance_stocks`
          where extract(month from date)= extract(month from NOW())
          and extract(year from date)= extract(year from NOW())
          ".$dept."
          ;";
    $result= mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
      while ($row = mysqli_fetch_assoc($result)){
        foreach ($stockArr as $stock){
          if ($stock->item_name==$row['item_name'] && $stock->dept==$row['dept']){
            $stock->qty=$row['qty'];
            $sql="SELECT SUM(qty) as finalstock
                  FROM `stocks`
                  where date > '".$row['date']."'
                  and `item_name` = '".$row['item_name']."'
                  and `dept` = '".$row['dept']."'
                  GROUP BY item_name, type;";
            $rowSQL= mysqli_query($con,$sql);
            if(mysqli_num_rows($rowSQL)>0){
              $row2 = mysqli_fetch_array($rowSQL);
              $stock->qty+=$row2['finalstock'];
            }
          }
        }
      }
    }
    mysqli_close($con);
    return $stockArr;
  }
