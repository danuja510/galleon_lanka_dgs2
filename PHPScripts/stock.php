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



  function viewStocksEmployee($dep)
  {
    return getCurrentStock($dept=$dep);
  }

  function viewStocksManager()
  {
    return getCurrentStock($dept="");
  }

  function viewStocksManagerFiltered($sort)
  {
    return getCurrentStock($dept=$sort);
  }

  function getCurrentStock($dept){
    $con = create_connection();
    $stockArr=[];


    if ($dept!="") {
      $sql="SELECT * FROM `balance_stocks` WHERE dept = '".$dept."' and date = (SELECT MAX(date) FROM `balance_stocks` WHERE dept = '".$dept."');";
      $rowSQL= mysqli_query($con,$sql);
      if(mysqli_num_rows($rowSQL)>0){
        while($row=mysqli_fetch_assoc($rowSQL)){
          $stockArr[sizeof($stockArr)]= new Stock($row['item_name'], $row['qty'], $row['type'], $row['dept']);
        }
        $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
              FROM `stocks`
              where date > '".mysqli_fetch_assoc($rowSQL)['date']."'
              and dept = '".$dept."'
              GROUP BY dept, item_name, type;";
      }else{
        $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
              FROM `stocks`
              and dept = '".$dept."'
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
        $sql="SELECT * FROM `balance_stocks` WHERE dept = '".$d."' and date = (SELECT MAX(date) FROM `balance_stocks` WHERE dept = '".$d."');";
        $rowSQL= mysqli_query($con,$sql);
        if(mysqli_num_rows($rowSQL)>0){
          while($row=mysqli_fetch_assoc($rowSQL)){
            $stockArr[sizeof($stockArr)]= new Stock($row['item_name'], $row['qty'], $row['type'], $row['dept']);
          }
          $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
                FROM `stocks`
                where date > '".mysqli_fetch_assoc($rowSQL)['date']."'
                and dept = '".$d."'
                GROUP BY dept, item_name, type;";
        }else{
          $sql="SELECT dept,item_name,type,SUM(qty) as finalstock
                FROM `stocks`
                and dept = '".$d."'
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
    mysqli_close($con);
    return $stockArr;
  }
