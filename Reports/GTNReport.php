<?php
session_start();
if(!isset($_SESSION['eno']))
  {
  header('Location:signIn.php');
  }
if(!isset($_SESSION['gtn']))
  {
    header('viewGTN.php');
  }

require ('../Resources/FPDF/fpdf.php');

class PDF extends FPDF
{

function header()
  {


      $this->SetFont('Arial','B',18);
      $this->cell(20);


      $this->line(10, 10, 210-10, 10);
      $this->line(10, 40, 210-10, 40);
      $this->cell(150,15,'GALLEON LANKA (PVT) LTD',0,1,'C');
      $this->cell(20);

      $this->SetFont('Arial','',10);
      $this->cell(150,8,'#67/A1,OLD ROAD, WETERA, POLGASOWITA',0,1,'C');
      $this->cell(20);
      $this->cell(150,8,'Tel: +94 11 4 423 928 / +94 76 440 1 440',0,1,'C');
      $this->Ln(8);

      $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
      {
        die("cannot connect to DB server");
      }

      $sql1="SELECT * FROM `gtn` where `gtn_no`=".$_SESSION['gtn']." GROUP BY gtn_no;";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);
      $date=$row['date'];
    	$remark=$row['remarks'];
    	$prpby=$row['prepared_by'];
    	$appby=$row['approved_by'];

      $this->SetFont('Arial','B',13);
      switch ($_SESSION['gtype']) {
        case 'in' :
        case 'return_in':
          $this->cell(190,8,'Stock In',0,1,'C');
          break;

        case 'out':
        case 'return_out':
          $this->cell(190,8,'Goods Transfer Note',0,1,'C');
          break;
      }
      $this->Ln(10);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'Department:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,"  ".$_SESSION['gdept'],0,0,'L');

      $this->cell(25,5,'Date',0,0,'L');


      $this->cell(25,5,$date,0,0,'L');

      $this->Ln(5);

      $this->SetFont('Arial','B',10);
      $this->cell(22,5,'Type:',0,0,'L');
      $this->SetFont('Arial','',10);

      switch ($_SESSION['gtype']) {
        case 'in':
          $this->cell(78,5,"stock in",0,0,'L');
          break;

        case 'return_in':
          $this->cell(78,5,"stock in (returns)",0,0,'L');
          break;

        case 'out':
          $this->cell(78,5,"gtn",0,0,'L');
          break;

        case 'return_out':
          $this->cell(78,5,"gtn (returns)",0,0,'L');
          break;
      }

      $this->cell(25,5,'GRN no.',0,0,'L');

      $this->cell(25,5,$_SESSION['gtn'],0,0,'L');

      $this->Ln(20);

      $this->SetFont('Arial','U',10);
      $this->cell(80,5,'Description of Goods',0,1);
      $this->SetFont('Arial','',10);
      $this->cell(80,5,"Remarks: $remark",0,1);

      $this->SetFont('Times','B','10');
      $this->cell(40,10,'Item Code','T',0,'L');
      $this->line(10, 110, 200, 110);
      $this->cell(80,10,'','T',0,'L');
      $this->cell(40,10,'Item Type','T',0,'L');
      $this->cell(30,10,'Qty.','T',1,'L');


      $this->SetFont('Times','B','10');

      $sql="SELECT * FROM `gtn` where `gtn_no`=".$_SESSION['gtn']." ";
      $rowSQL1= mysqli_query($con,$sql);
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
        $this->cell(40,10,$row1['item_name'],0,0,'L');
        $this->cell(80,10,'',0,0,'L');
        $this->cell(40,10,$row1['item_type'],0,0,'L');
        $this->cell(30,10,$row1['qty'],0,1,'L');
      }



      $this->Ln(20);

      $this->cell(50,5,'..................................',0,0,'C');
      $this->cell(85,5,'..................................',0,0,'C');
      $this->cell(70,5,'..................................',0,1,'C');
      $this->cell(50,5,"Prepared by Emp no. $prpby",0,0,'C');
      $this->cell(85,5,"Approved by Emp no. $appby",0,0,'C');
      $this->multicell(70,5,"Signature & stamp \n received the above items in \n good order & condition",0,'C');

      $this->Ln(20);

  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--dan-->
