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
        $sum=$row['sum'];
        $cust=$row['cno'];
        $date=$row['date'];
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

      $this->Ln(20);

      $this->SetFont('Arial','',10);

      $this->SetFont('Times','B','10');
      $this->cell(30,10,'Invoice no.','T',0,'L');
      $this->line(10, 105, 210-8, 105);
      // $this->cell(80,10,'Item Description','T',0,'L');
      // $this->cell(30,10,'Unit Price','T',0,'L');
      $this->cell(140,10,'','T',0,'L');
      $this->cell(22,10,'Amount','T',1,'L');

      $this->SetFont('Times','B','10');
      $sum1=0;
      $sql="SELECT `amout` FROM `cash_receipts` where `cr_no`=".$_SESSION['CR']." ";
      $rowSQL1= mysqli_query($con,$sql);
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
          // $this->cell(30,10,$row['mid'],0,0,'L');
          // $this->cell(80,10,$row['Name'],0,0,'L');
          // $this->cell(30,10,$amt,0,0,'L');
          $this->cell(170,10,$i,0,0,'L');
          $this->cell(15,10,$row1['amout'],0,1,'L');
          $sum1=$sum1+$row1['amout'];
      }
          $this->Ln(10);

          //$this->line(10, 133, 210-10, 133);
          //$this->line(10, 140, 210-10, 140);
          $this->cell(110,10,'','T,B',0,'');
          $this->cell(10,10,'Total Rs.','T,B',0,'L');
          $this->cell(50,10,'','T,B',0,'');
          $this->cell(20,10,$sum1,'T,B',1,'L');


          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(85,5,'..................................',0,0,'C');
          $this->cell(70,5,'..................................',0,1,'C');
          $this->cell(50,5,"Prepared by Emp no. $prpby",0,0,'C');
          $this->cell(85,5,"Approved by Emp no. $appby",0,0,'C');

          $this->Ln(20);

  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--sithara-->
