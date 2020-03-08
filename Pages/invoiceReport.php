<?php
session_start();
if(!isset($_SESSION['eno']))
  {
  header('Location:signIn.php');
  }
if(!isset($_SESSION['invoice']))
  {
    header('viewInvoice.php');
  }

require ('../FPDF lib/fpdf.php');

class PDF extends FPDF
{

function header()
  {

      //$this->Image('../assets/logo.png',10,10,30,20);

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
      $this->cell(190,8,'INVOICE',0,1,'C');
      $this->Ln(10);

    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }

        $sql1="SELECT *,SUM(total) AS sum FROM `invoice` where `invoice_no`=".$_SESSION['invoice']." GROUP BY invoice_no;";
        $rowSQL1= mysqli_query($con,$sql1);
        $row = mysqli_fetch_assoc($rowSQL1);
        $sum=$row['sum'];
        $cust=$row['cno'];
        $date=$row['date'];
	$remark=$row['remarks'];
	$prpby=$row['prepared_by'];
      	$appby=$row['approved_by'];

      //getting customer name
      $sql1="SELECT * FROM `customer` where `cno`=$cust;";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'Customer:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,$row['Name'],0,0,'L');
      $cname=$row['Name'];
      $caddress=$row['Address'];

      $this->cell(25,5,'Date',0,0,'L');


      $this->cell(80,5,$date,0,0,'L');

      $this->Ln(5);
      $this->cell(20);


      $this->cell(80,5,$caddress,0,0,'L');

      $this->cell(25,5,'Invoice no.',0,0,'L');

      $this->cell(25,5,$_SESSION['invoice'],0,0,'L');

      $this->Ln(20);

      $this->SetFont('Arial','U',10);
      $this->cell(80,5,'Description of Goods',0,1);
      $this->SetFont('Arial','',10);
      $this->cell(80,5,"Remarks: $remark",0,1);

      //$this->Ln(10);
      $this->SetFont('Times','B','10');
      //$this->line(10, 105, 210-10, 105);
      $this->cell(30,10,'Item Code','T',0,'L');
      $this->line(10, 110, 210-8, 110);
      $this->cell(80,10,'Item Description','T',0,'L');
      $this->cell(30,10,'Unit Price','T',0,'L');
      $this->cell(30,10,'Qty.','T',0,'L');
      $this->cell(22,10,'Amount','T',1,'L');


      $this->SetFont('Times','B','10');

      //getting finished goods details
      $sql="SELECT `item_no`,`qty`,`value`,`total` FROM `invoice` where `invoice_no`=".$_SESSION['invoice']." ";
      $rowSQL1= mysqli_query($con,$sql);
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
      $ino=$row1['item_no'];
      $qty=$row1['qty'];
      $val=$row1['value'];
        $sql="SELECT `fp_id`,`Name` FROM `finished_products` where `fp_id`=$ino;";
        $rowSQL2= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL2))
        {
          $this->cell(30,10,$row['fp_id'],0,0,'L');
          $this->cell(80,10,$row['Name'],0,0,'L');
          $this->cell(30,10,$val,0,0,'L');
          $this->cell(30,10,$qty,0,0,'L');
          $this->cell(15,10,$row1['total'],0,1,'L');

        }
      }
          $this->Ln(10);

          //$this->line(10, 133, 210-10, 133);
          //$this->line(10, 140, 210-10, 140);
          $this->cell(110,10,'','T,B',0,'');
          $this->cell(10,10,'Total Rs.','T,B',0,'L');
          $this->cell(50,10,'','T,B',0,'');
          $this->cell(20,10,$sum,'T,B',1,'L');

          $this->SetFont('Times','I','10');
          $this->cell(10,10,'*Cash on delivery',0,1,'L');
          $this->cell(10,5,'*Please make your payments to either:',0,1,'L');
          $this->cell(10,5,'Galleon Lanka (Pvt) Ltd - Cargills Bank Ac no 0209xxxxxxxx or',0,1,'L');
          $this->cell(10,5,'H M D K Dabare - Commercial Bank Ac no 877xxxxxxx',0,1,'L');

          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(50,5,"Prepared by Emp no. $prpby",0,0,'C');
          $this->cell(85,5,"Approved by Emp no. $appby",0,0,'C');
          $this->multicell(70,5,"Signature & stamp \n received the above items in \n good order & condition",0,'C');

          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(50,5,'Loaded by',0,0,'C');
          $this->cell(85,5,'Drivers name and signature',0,0,'C');
          $this->multicell(70,5,"Vehicle Number",0,'C');

  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--gima-->
