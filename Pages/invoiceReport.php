<?php
session_start();

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

      $sql1="SELECT * FROM `customer` where `cno`='1';";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'customer:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,$row['Name'],0,0,'L');

      $this->cell(25,5,'Date',0,0,'L');

      $sql="SELECT * FROM `invoice` where `no`='1';";
      $rowSQL= mysqli_query($con,$sql);
      $row = mysqli_fetch_assoc( $rowSQL);

      $this->cell(80,5,$row['date'],0,0,'L');

      $this->Ln(5);
      $this->cell(20);

      $sql1="SELECT * FROM `customer` where `cno`='1';";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc( $rowSQL1);

      $this->cell(80,5,$row['Address'],0,0,'L');

      $this->cell(25,5,'Invoice no.',0,0,'L');

      $sql="SELECT * FROM `invoice` where `no`='1';";
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
      $this->line(10, 110, 210-15, 110);
      $this->cell(80,10,'item description','T',0,'L');
      $this->cell(30,10,'unit price','T',0,'L');
      $this->cell(30,10,'qty','T',0,'L');
      $this->cell(15,10,'amount','T',1,'L');


      $this->SetFont('Times','B','10');

      $sql="SELECT * FROM `invoice` ;";
      $rowSQL1= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL1))
        {
          $this->cell(30,10,$row['item_no'],0,0,'L');
          $this->cell(80,10,$row['item_no'],0,0,'L');
          $this->cell(30,10,$row['item_no'],0,0,'L');
          $this->cell(30,10,$row['qty'],0,0,'L');
          $this->cell(15,10,$row['total'],0,1,'L');

        }
          $sql1="SELECT * FROM `invoice` where `no`='1';";
          $rowSQL2= mysqli_query($con,$sql1);
          $row1 = mysqli_fetch_assoc( $rowSQL2);

          $this->line(10, 133, 210-10, 133);
          $this->line(10, 140, 210-10, 140);
          $this->cell(110);
          $this->cell(10,10,'total Rs.',0,0,'L');
          $this->cell(50);
          $this->cell(10,10,$row1['total'],0,1,'L');

          $this->SetFont('Times','I','10');
          $this->cell(10,10,'*cash on delivery',0,1,'L');
          $this->cell(10,5,'*please make your payments to either;',0,1,'L');
          $this->cell(10,5,'Galleon Lanka (Pvt) Ltd - Cargills Bank Ac no 0209xxxxxxxx or',0,1,'L');
          $this->cell(10,5,'H M D K Dabare - Commercial Bank Ac no 877xxxxxxx',0,1,'L');

          $this->Ln(20);

          $this->cell(70,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(70,5,'Prepared by',0,0,'C');
          $this->cell(70,5,'Approved by',0,0,'C');
          $this->multicell(70,5,"Signature & stamp \n received the above items in \n good order & condition",0,'C');

          $this->Ln(20);

          $this->cell(70,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(70,5,'Loaded by',0,0,'C');
          $this->cell(70,5,'Drivers name and signature',0,0,'C');
          $this->multicell(70,5,"vehicle number",0,'C');


  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--gima-->
