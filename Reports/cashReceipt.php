<?php
session_start();
if(!isset($_SESSION['eno']))
  {
  header('Location:signIn.php');
  }
  if(!isset($_SESSION['CR'])){
    header('Location:viewcashreceipt.php');
  }

require ('../Resources/FPDF/fpdf.php');

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
      $this->cell(190,8,'CASH RECEIPT',0,1,'C');
      $this->Ln(10);

    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }

        $sql1="SELECT *,SUM(amout) AS sum FROM `cash_receipts` where `cr_no`=".$_SESSION['CR']." GROUP BY cr_no,invoice_no;";
        $rowSQL1= mysqli_query($con,$sql1);
        $row = mysqli_fetch_assoc($rowSQL1);
        $amount=$row['sum'];
        $cust=$row['cno'];
        $date=$row['date'];
        $remark=$row['remarks'];
        $i=$row['invoice_no'];
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
      $address=$row['Address'];

      $this->cell(35,5,'Date',0,0,'L');


      $this->cell(80,5,$date,0,0,'L');

      $this->Ln(5);
      $this->cell(20);


      $this->cell(80,5,$address,0,0,'L');

      $this->cell(35,5,'Cash Receipt no.',0,0,'L');

      $this->cell(25,5,$_SESSION['CR'],0,0,'L');

      $this->Ln(10);

      $this->SetFont('Arial','U',10);
      $this->SetFont('Arial','',10);
      $this->cell(80,5,"Remarks: $remark",0,1);
    
    $this->Ln(10);

      //$this->Ln(10);
      $this->SetFont('Times','B','10');
      //$this->line(10, 105, 210-10, 105);

          $this->Ln(10);

          //$this->line(10, 133, 210-10, 133);
          //$this->line(10, 140, 210-10, 140);
          $this->cell(100,10,'','T,B',0,'');
          $this->cell(10,10,'Total Rs.','T,B',0,'L');
          $this->cell(25,10,'','T,B',0,'');
          $this->cell(30,10,$amount,'T,B',0,'L');
            $this->cell(25,10,'','T,B',1,'L');

          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(60,5,'..................................',0,1,'C');
            $this->cell(10,5,'',0,0,'C');
          $this->cell(30,5,"Prepared by Emp no. $prpby",0,0,'C');
          $this->cell(110,5,"Approved by Emp no. $appby",0,0,'C');
          $this->cell(70,5,"Signature & stamp",0,'C');

          $this->Ln(20);


          $this->Ln(20);


  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--sithara-->
