<?php
session_start();
//if(!isset($_SESSION['Print_invoice']))
//  {
//    header('viewInvoice.php');
//  }

require ('../FPDF lib/fpdf.php');

class PDF extends FPDF
{

function header()
  {

      $this->Image('../FPDF lib/logo.png',10,10,30,20);

      $this->SetFont('Arial','B',18);

      $this->cell(20);


      //$this->rect(5,5,200,35,'D');
      $this->line(10, 10, 210-10, 10);
      $this->line(10, 40, 210-10, 40);
      $this->cell(150,15,'GALLEON LANKA (PVT) LTD',0,1,'C');
      $this->cell(20);

      $this->SetFont('Arial','',10);
      $this->cell(150,8,'#67/A1,OLD ROAD, WETERA, POLGASOWITA',0,1,'C');
      $this->cell(20);
      $this->cell(150,8,'Tel: +94 11 4 423 928 / +94 76 440 1 440',0,1,'C');
      $this->Ln(8);

      $this->SetFont('Arial','B',13);
      $this->cell(210,8,'INVOICE',0,1,'C');
      $this->Ln(10);

    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }

        $sql1="SELECT * FROM `invoice`;";         // add session
        $rowSQL1= mysqli_query($con,$sql1);
        $row = mysqli_fetch_assoc($rowSQL1);
        $cust=$row['cno'];
                                                                    //getting customer name
      $sql1="SELECT * FROM `customer` where `cno`=$cust;";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'customer:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,$row['Name'],0,0,'L');

      $this->cell(25,5,'Date',0,0,'L');

      $sql="SELECT * FROM `invoice` where `invoice_no`='22';";   //add session
      $rowSQL= mysqli_query($con,$sql);
      $row = mysqli_fetch_assoc( $rowSQL);


      $this->cell(80,5,$row['date'],0,0,'L');

      $this->Ln(5);
      $this->cell(20);

      $sql1="SELECT * FROM `customer` where `cno`=$cust;";            //getting customer addr
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc( $rowSQL1);

      $this->cell(80,5,$row['Address'],0,0,'L');

      $this->cell(25,5,'Invoice no.',0,0,'L');

      $sql="SELECT * FROM `invoice` where `invoice_no`='22';";   //add session
      $rowSQL= mysqli_query($con,$sql);
      $row = mysqli_fetch_assoc( $rowSQL);

      $this->cell(25,5,$row['invoice_no'],0,0,'L');

      $this->Ln(20);

      $this->SetFont('Arial','U',10);
      $this->cell(80,5,'Description of goods',0,1);
      $this->SetFont('Arial','',10);
      $this->cell(80,5,'Remark',0,1);

      //$this->Ln(10);
      $this->SetFont('Times','B','10');
      //$this->line(10, 105, 210-10, 105);
      $this->cell(30,10,'item code','T',0,'L');
      $this->line(10, 110, 210-8, 110);
      $this->cell(80,10,'item description','T',0,'L');
      $this->cell(30,10,'unit price','T',0,'L');
      $this->cell(30,10,'qty','T',0,'L');
      $this->cell(22,10,'amount','T',1,'L');


      $this->SetFont('Times','B','10');

      $sql="SELECT `item_no`,`qty` FROM `invoice` where `invoice_no`='22' group by `item_no`,`qty`;";    /////////////session////////////////////
      $rowSQL1= mysqli_query($con,$sql);
      $sum=0;
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
      $ino=$row1['item_no'];
      $qty=$row1['qty'];

        $sql="SELECT `fp_id`,`Name`,`value` FROM `finished_products` where `fp_id`=$ino group by `fp_id`,`Name`,`value`;";
        $rowSQL2= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL2))
        {
          $this->cell(30,10,$row['fp_id'],0,0,'L');
          $this->cell(80,10,$row['Name'],0,0,'L');
          $this->cell(30,10,$row['value'],0,0,'L');
          $this->cell(30,10,$qty,0,0,'L');
          $tot=$qty*$row['value'];
          $sum=$tot+$sum;
          $this->cell(15,10,$tot,0,1,'L');

        }
      }
          $this->Ln(10);

          $sql1="SELECT * FROM `invoice` where `no`='1';"; ///////////////////////////
          $rowSQL2= mysqli_query($con,$sql1);
          $row1 = mysqli_fetch_assoc( $rowSQL2);

          //$this->line(10, 133, 210-10, 133);
          //$this->line(10, 140, 210-10, 140);
          $this->cell(110,10,'','T,B',0,'');
          $this->cell(10,10,'total Rs.','T,B',0,'L');
          $this->cell(50,10,'','T,B',0,'');
          $this->cell(20,10,$sum,'T,B',1,'L'); ///////////////////////////////////

          $this->SetFont('Times','I','10');
          $this->cell(10,10,'*cash on delivery',0,1,'L');
          $this->cell(10,5,'*please make your payments to either;',0,1,'L');
          $this->cell(10,5,'Galleon Lanka (Pvt) Ltd - Cargills Bank Ac no 0209xxxxxxxx or',0,1,'L');
          $this->cell(10,5,'H M D K Dabare - Commercial Bank Ac no 877xxxxxxx',0,1,'L');

          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(50,5,'Prepared by',0,0,'C');
          $this->cell(85,5,'Approved by',0,0,'C');
          $this->multicell(70,5,"Signature & stamp \n received the above items in \n good order & condition",0,'C');

          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(50,5,'Loaded by',0,0,'C');
          $this->cell(85,5,'Drivers name and signature',0,0,'C');
          $this->multicell(70,5,"vehicle number",0,'C');

  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--gima-->
