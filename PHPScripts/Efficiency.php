<?php
  require '../Database/db.php';

  class efficiency{

    public $itemID;
    public $eff;
    public $dif;
    public $in =0;
    public $bf =0;
    public $stock =0;
    public $balance_stock = 0;
    public $out =0;
    public $return_in =0;
    public $return_out = 0;

    function __construct($itemID){
      $this->itemID = $itemID;
    }
  }

  function efClass(float $ef){

    if ($ef==1){
        $class="light-green";
    }elseif ($ef>1){
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

  function getDeptEfficiencyMonthly($dept, $y, $m){
    $where[0] = "AND extract(month from date)= '".$m."'
              AND extract(year from date)= '".$y."'";
    $where[1] = "AND date< '".$y."-".$m."-01'";
    return getDeptEfficiency($dept, $where);
  }

  function getDeptEfficiencyYearly($dept, $y){
    $where[0] = "AND extract(year from date)='".$y."'";
    $where[1] = "AND date< '$y-01-01'";
    return getDeptEfficiency($dept, $where);
  }

  function getDeptEfficiencyFull($dept){
    $where[0] = "";
    $where[1] = "";
    return getDeptEfficiency($dept, $where);
  }

  function getDeptEfficiency($dept, $where){
    $con = create_connection();

    $sql="SELECT max(date)
          FROM `balance_stocks`
          where dept = '$dept'
          $where[0];";
    $result= mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $sql="SELECT MAX(date) as mdate
          FROM `stocks`
          WHERE dept = '$dept'
          $where[0];";
    $result2= mysqli_query($con,$sql);
    $row2 = mysqli_fetch_assoc($result2);

    $from_date="";
    $to_date="";

    $eff = [];
    $exception = 0;
    $tot_eff = 0;

    if ($row2['mdate']==NULL) {
      $exception = 1;
      return [$eff, $tot_eff, $exception];
    }elseif (mysqli_num_rows($result)>0) {


      if ($where[0]!="") {
        $sql="SELECT item_name,type,qty, date
  		        FROM `balance_stocks`
  		        WHERE dept = '$dept'
              $where[1]
  						and date >= all(
  							SELECT DATE_FORMAT(date, '%Y-%c-%d %H:%i')
                FROM `balance_stocks`
                WHERE dept = '".$dept."'
  							$where[1]
  						);";
        $eff = calEfficiency($sql, 'bf', $eff, NULL);
        $rowSQL= mysqli_query( $con,$sql);
        $from_date = mysqli_fetch_assoc( $rowSQL )['date'];
      }

      $sql="SELECT dept,item_name,type,qty, date
            FROM `balance_stocks`
            WHERE dept='$dept'
            $where[0]
            and date >= all(
              SELECT DATE_FORMAT(date, '%Y-%c-%d %H:%i')
              FROM `balance_stocks`
              WHERE dept = '$dept'
              $where[0]
            );";
      $eff = calEfficiency($sql, 'balance_stock', $eff, NULL);
      $rowSQL= mysqli_query( $con,$sql);
      $to_date = mysqli_fetch_assoc( $rowSQL )['date'];

      if ($where[0]!="" && $from_date != ""){
        $sql="SELECT item_name,SUM(qty) AS qty
  	          from stocks
  	          WHERE dept='$dept'
  						AND date between '$from_date' and '$to_date'
  	          GROUP BY item_name;";
      }else{
        $sql="SELECT item_name,SUM(qty) AS qty
              from stocks
              WHERE dept='$dept'
              AND date < '$to_date'
              GROUP BY item_name;";
      }
      $eff = calEfficiency($sql, 'stock', $eff, NULL);

      return [$eff, $tot_eff, $exception, [$from_date, $to_date]];
    }else {
      $exception = 2;
      return [$eff, $tot_eff, $exception];
    }
  }

  function calEfficiency($sql, $type, $eff, $other){
    $con = create_connection();
    $rowSQL= mysqli_query( $con,$sql);
    while($row=mysqli_fetch_assoc( $rowSQL )){
      for ($j=0; $j <sizeof($eff) ; $j++) {
        if ($row['item_name']==$eff[$j]->itemID) {
          switch ($type) {
            case 'bf':
              $eff[$j]->bf+=$row['qty'];
              $eff[$j]->stock+=$row['qty'];
              continue 3;

            case 'in':
              if ($other != NULL) {
                $eff[$j]->in+=$other;
              }else {
                $eff[$j]->in+=$row['qty'];
              }
              continue 3;

            case 'stock':
              $eff[$j]->stock+=$row['qty'];
              continue 3;

            case 'balance_stock':
              $eff[$j]->balance_stock+=$row['qty'];
              continue 3;

            case 'out':
              $eff[$j]->out+=$row['qty'];
              continue 3;

            case 'return_out':
              $eff[$j]->return_out+=$row['qty'];
              continue 3;

            case 'return_in':
              $eff[$j]->return_in+=$row['qty'];
              continue 3;
          }

        }
      }
      if ($other != NULL && $other!=0) {
        $eff[sizeof($eff)]= new efficiency($row['item_name']);
        $eff[sizeof($eff)-1]->in+=$other;
      }elseif($row['qty']!=0){
          $eff[sizeof($eff)]= new efficiency($row['item_name']);
          switch ($type) {
            case 'bf':
              $eff[sizeof($eff)-1]->bf+=$row['qty'];
              $eff[sizeof($eff)-1]->stock+=$row['qty'];
              break;

            case 'in':
              $eff[sizeof($eff)-1]->in+=$row['qty'];
              break;

            case 'stock':
              $eff[sizeof($eff)-1]->stock+=$row['qty'];
              break;

            case 'balance_stock':
              $eff[sizeof($eff)-1]->balance_stock+=$row['qty'];
              break;

            case 'out':
              $eff[sizeof($eff)-1]->out+=$row['qty'];
              break;

            case 'return_out':
              $eff[sizeof($eff)-1]->return_out+=$row['qty'];
              break;

            case 'return_in':
              $eff[sizeof($eff)-1]->return_in+=$row['qty'];
              break;
          }
        }
    }

    return $eff;
  }

  function processEfficiency($eff, $dept){
    echo "<div class='row'>
            <div class='col span-1-of-2'>";
    if($eff[2]==0){
        for ($j=0; $j <sizeof($eff[0]) ; $j++) {
        $eff[0][$j]->dif=$eff[0][$j]->balance_stock - $eff[0][$j]->stock;
        if ($eff[0][$j]->balance_stock==0 || $eff[0][$j]->stock==0) {
          if ($eff[0][$j]->balance_stock==0 && $eff[0][$j]->stock==0) {
            $eff[0][$j]->eff=1;
          }else {
            $eff[0][$j]->eff=0;
          }
        }else{
          $eff[0][$j]->eff=$eff[0][$j]->balance_stock / $eff[0][$j]->stock;
        }
        $eff[1]+=$eff[0][$j]->eff;
        }
        if($eff[1]>0){
            $class= efClass($eff[1]/sizeof($eff[0]));
            echo "Efficiency of $dept =<span class=".$class."><strong>".round($eff[1]/sizeof($eff[0])*100,2)."%</strong></span><br>";
        }else{
            $class= efClass(0);
            echo "Efficiency of $dept =<span class=".$class."><strong>0%</strong></span><br>";
        }
        echo "<span style='font-size:70%;'>During the period<br> <strong>";
        if ($eff[3][0]=="") {
          echo "begining";
        }else {
          echo $eff[3][0];
        }
        echo "</strong> — <strong>".$eff[3][1]."</strong></span><br><span style='font-size:65%;'>*Update Balance Stocks to view the latest statistics</span>";
    }elseif($eff[2]==1){
        echo "No Recorded Operations ";
    }elseif ($eff[2]==2) {
      echo "Balance stocks hasn't been updated in this period";
    }
    echo "</div>
          <div class='col span-1-of-2'>";
    if($eff[2]==0){
        echo "<table>
                <thead>
                    <th>Item Name</th><th>Balance Stock Brought Forward</th><th>Calculated Stock</th><th>Updated Balance Stock</th><th>Difference</th><th>Item Efficiency</th>
                </thead>";
        for ($j=0; $j <sizeof($eff[0]) ; $j++) {
          $class = efClass($eff[0][$j]->eff);
          echo "
          <tr>
            <td class=".$class."><strong>".$eff[0][$j]->itemID."</strong></td>
            <td class=".$class."><strong>".$eff[0][$j]->bf."</strong></td>
            <td class=".$class."><strong>".$eff[0][$j]->stock."</strong></td>
            <td class=".$class."><strong>".$eff[0][$j]->balance_stock."</strong></td>
            <td class=".$class."><strong>".$eff[0][$j]->dif."</strong></td>
            <td class=".$class."><strong>".round($eff[0][$j]->eff,2)."</strong></td>
        </tr>";
       }
        echo "</table>";
    }else{
      if($eff[2]==1){
          echo "No Recorded Operations ";
      }elseif ($eff[2]==2) {
        echo "Balance stocks hasn't been updated in this period";
      }
    }
    echo "  </div>
          </div>";
  }

  function getTransferEfficiencyMonthly($fromDept, $toDept, $y, $m){
    $where = "AND extract(month from date)= '".$m."'
              AND extract(year from date)= '".$y."'";
    return getTransferEfficiency($fromDept, $toDept, $where);
  }

  function getTransferEfficiencyYearly($fromDept, $toDept, $y){
    $where = "AND extract(year from date)='".$y."'";
    return getTransferEfficiency($fromDept, $toDept, $where);
  }

  function getTransferEfficiencyFull($fromDept, $toDept){
    $where = "";
    return getTransferEfficiency($fromDept, $toDept, $where);
  }

  function getTransferEfficiency($fromDept, $toDept, $where){
    $con = create_connection();

    $eff = [];
    $tot_eff = 0;

    $sql="SELECT item_name,SUM(qty) AS qty
          FROM `gtn`
          WHERE dept='$fromDept'
          AND type='out'
          $where
          and approved_by IS NOT null
          GROUP BY item_name";
    $eff = calEfficiency($sql, 'out', $eff, NULL);

    $sql="SELECT item_name,SUM(qty) AS qty
          FROM `gtn`
          WHERE dept= '$toDept'
          $where
          AND type='in'
          And approved_by IS NOT null
          GROUP BY item_name";
    $eff = calEfficiency($sql, 'in', $eff, NULL);

    $sql="SELECT item_name,SUM(qty) AS qty
            FROM `gtn`
            WHERE dept='$toDept'
            AND type='return_out'
            $where
            and approved_by IS NOT null
            GROUP BY item_name";
    $eff = calEfficiency($sql, 'return_out', $eff, NULL);

    $sql="SELECT item_name,SUM(qty) AS qty
            FROM `gtn`
            WHERE dept='$fromDept'
            AND type='return_in'
            $where
            and approved_by IS NOT null
            GROUP BY item_name";
    $eff = calEfficiency($sql, 'return_in', $eff, NULL);

    return [$eff, $tot_eff];
  }

  function processTransferEfficiency($eff, $fromDept, $toDept){
    echo "<div class='row'>
            <div class='col span-1-of-2'>";
    if(sizeof($eff[0])>0){
        for ($j=0; $j <sizeof($eff[0]) ; $j++) {
        $eff[0][$j]->dif=($eff[0][$j]->out + $eff[0][$j]->return_out)- ($eff[0][$j]->in + $eff[0][$j]->return_in);
        if (($eff[0][$j]->out + $eff[0][$j]->return_out)==0 || ($eff[0][$j]->in + $eff[0][$j]->return_in)==0) {
          if (($eff[0][$j]->out + $eff[0][$j]->return_out)==0 && ($eff[0][$j]->in + $eff[0][$j]->return_in)==0) {
            $eff[0][$j]->eff=1;
          }else {
            $eff[0][$j]->eff=0;
          }
        }else{
          $eff[0][$j]->eff=($eff[0][$j]->out + $eff[0][$j]->return_out) / ($eff[0][$j]->in + $eff[0][$j]->return_in);
        }
        $eff[1]+=$eff[0][$j]->eff;
        }
        if($eff[1]>0){
            $class= efClass($eff[1]/sizeof($eff[0]));
            echo "Efficiency of transfers between $fromDept and $toDept =<span class=".$class."><strong>".round($eff[1]/sizeof($eff[0])*100,2)."%</strong></span><br>";
        }else{
            $class= efClass(0);
            echo "Efficiency of transfers between $fromDept and $toDept =<span class=".$class."><strong>0%</strong></span><br>";
        }
        if (isset($_GET['y'])) {
          echo "<span style='font-size:70%;'>During <strong>".$_GET['y']."</strong>";
          if (isset($_GET['m'])) {
            echo " - <strong>".$_GET['m']."</strong>";
          }
          echo "</span>";
        }
    }else{
      echo "No transfers between $fromDept and $toDept";
    }
    echo "</div>
          <div class='col span-1-of-2'>";
    if(sizeof($eff[0])>0){
      echo "<table>
              <thead>
                  <th>Item Name</th><th>$fromDept OUT</th><th>$toDept IN</th><th>$toDept RETURN OUT</th><th>$fromDept RETURN IN</th><th>Difference</th><th>Item Efficiency</th>
              </thead>";
      for ($j=0; $j <sizeof($eff[0]) ; $j++) {
        $class = efClass($eff[0][$j]->eff);
        echo "
        <tr>
          <td class=".$class."><strong>".$eff[0][$j]->itemID."</strong></td>
          <td class=".$class."><strong>".$eff[0][$j]->out."</strong></td>
          <td class=".$class."><strong>".$eff[0][$j]->in."</strong></td>
          <td class=".$class."><strong>".$eff[0][$j]->return_out."</strong></td>
          <td class=".$class."><strong>".$eff[0][$j]->return_in."</strong></td>
          <td class=".$class."><strong>".$eff[0][$j]->dif."</strong></td>
          <td class=".$class."><strong>".round($eff[0][$j]->eff,2)."</strong></td>
      </tr>";
     }
      echo "</table>";
    }else{
      echo "No transfers between $fromDept and $toDept";
    }
    echo "  </div>
        </div>";
  }
