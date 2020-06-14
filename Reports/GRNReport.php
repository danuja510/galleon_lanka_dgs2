<?php
session_start();
if(!isset($_SESSION['eno']))
  {
  header('Location:signIn.php');
  }
if(!isset($_SESSION['grn']))
  {
    header('viewGRN2.php');
  }

require ('../Resources/FPDF/fpdf.php');

class PDF extends FPDF
{

function header()
  {


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
      $this->cell(190,8,'Goods Received Note',0,1,'C');
      $this->Ln(10);

    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }

        $sql1="SELECT *,SUM(amount) AS sum FROM `grn` where `grn_no`=".$_SESSION['grn']." GROUP BY grn_no;";
        $rowSQL1= mysqli_query($con,$sql1);
        $row = mysqli_fetch_assoc($rowSQL1);
        $sum=$row['sum'];
        $sup=$row['sid'];
        $date=$row['date'];
	$remark=$row['remarks'];
	$prpby=$row['prepared_by_(eno)'];
      	$appby=$row['approvedBy'];

      //getting supplier name
      $sql1="SELECT * FROM `supplier` where `sid`=$sup;";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'Supplier:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,$row['Name'],0,0,'L');
      $sname=$row['Name'];
      $saddress=$row['Address'];

      $this->cell(25,5,'Date',0,0,'L');


      $this->cell(80,5,$date,0,0,'L');

      $this->Ln(5);
      $this->cell(20);


      $this->cell(80,5,$saddress,0,0,'L');

      $this->cell(25,5,'GRN no.',0,0,'L');

      $this->cell(25,5,$_SESSION['grn'],0,0,'L');

      $this->Ln(20);

      $this->SetFont('Arial','U',10);
      $this->cell(80,5,'Description of Goods',0,1);
      $this->SetFont('Arial','',10);
      $this->cell(80,5,"Remarks: $remark",0,1);

      $this->SetFont('Times','B','10');
      $this->cell(30,10,'Meterial No','T',0,'L');
      $this->line(10, 110, 210-8, 110);
      $this->cell(60,10,'Meterial Name/Code','T',0,'L');
      $this->cell(30,10,'Meterial Type','T',0,'L');
      $this->cell(30,10,'Unit Price','T',0,'L');
      $this->cell(20,10,'Qty.','T',0,'L');
      $this->cell(22,10,'Amount','T',1,'L');


      $this->SetFont('Times','B','10');

      //getting material details
      $sql="SELECT * FROM `grn` where `grn_no`=".$_SESSION['grn']." ";
      $rowSQL1= mysqli_query($con,$sql);
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
      $ino=$row1['mid'];
      $qty=$row1['qty'];
      $val=$row1['amount'];
        $sql="SELECT `mid`,`Name`,`type`,`value` FROM `materials` where `mid`=$ino;";
        $rowSQL2= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL2))
        {
          $this->cell(30,10,$row['mid'],0,0,'L');
          $this->cell(60,10,$row['Name'],0,0,'L');
          $this->cell(30,10,$row['type'],0,0,'L');
          $this->cell(30,10,$row['value'],0,0,'L');
          $this->cell(20,10,$qty,0,0,'L');
          $this->cell(15,10,$row1['amount'],0,1,'L');

        }
      }
          $this->Ln(10);

          $this->cell(110,10,'','T,B',0,'');
          $this->cell(10,10,'Total Rs.','T,B',0,'L');
          $this->cell(50,10,'','T,B',0,'');
          $this->cell(20,10,round($sum,2),'T,B',1,'L');

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
