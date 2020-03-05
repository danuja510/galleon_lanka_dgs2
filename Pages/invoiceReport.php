<?php
session_start();

require ('fpdf.php');

class PDF extends FPDF
{

function header()
  {

      $this->Image('logo.png',10,10,30,20);

      $this->SetFont('Arial','B',18);

      $this->cell(20);


      $this->rect(5,5,200,35,'D');
      $this->cell(150,15,'GALLEON LANKA (PVT) LTD',0,1,'C');
      $this->cell(20);

      $this->SetFont('Arial','',10);
      $this->cell(150,8,'#67/A1,OLD ROAD, WETERA, POLGASOWITA',0,1,'C');
      $this->cell(20);
      $this->cell(150,8,'tel #: 122334',0,1,'C');
      $this->Ln(8);

      $this->SetFont('Arial','B',13);
      $this->cell(200,8,'INVOICE',0,1,'C');
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

      $sql="SELECT * FROM `invoice` where `no`='1';";
      $rowSQL1= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL1))
        {
          $this->cell(30,10,$row['item_no'],0,0,'L');
          $this->cell(80,10,$row['item_no'],0,0,'L');
          $this->cell(30,10,$row['item_no'],0,0,'L');
          $this->cell(30,10,$row['qty'],0,0,'L');
          $this->cell(15,10,$row['total'],0,0,'L');
          $this->Ln();
        }
  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--gima-->
