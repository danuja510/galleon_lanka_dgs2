<?php
session_start();
if(!isset($_SESSION['eno']))
  {
  header('Location:signIn.php');
  }
if(!isset($_SESSION['pOrder']))
  {
    header('viewPurchaseOrder.php');
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
      $this->cell(190,8,'PURCHASE ORDER',0,1,'C');
      $this->Ln(10);

    $con = mysqli_connect("localhost","root","","galleon_lanka");
      if(!$con)
        {
          die("cannot connect to DB server");
        }

        $sql1="SELECT *,SUM(amount) AS sum FROM `purchase_orders` where `po_no`=".$_SESSION['pOrder']." GROUP BY po_no;";
        $rowSQL1= mysqli_query($con,$sql1);
        $row = mysqli_fetch_assoc($rowSQL1);
        $sum=$row['sum'];
        $supp=$row['sid'];
        $date=$row['prep_date'];

	      $prpby=$row['prepared_by_(eno)'];
      	$appby=$row['approvedBy'];

      //getting supplier name
      $sql1="SELECT * FROM `supplier` where `sid`=$supp;";
      $rowSQL1= mysqli_query($con,$sql1);
      $row = mysqli_fetch_assoc($rowSQL1);

      $this->SetFont('Arial','B',10);
      $this->cell(20,5,'Supplier:',0,0,'L');
      $this->SetFont('Arial','',10);

      $this->cell(80,5,$row['Name'],0,0,'L');
      //$sname=$row['Name'];
      $saddress=$row['Address'];

      $this->cell(35,5,'Date',0,0,'L');


      $this->cell(80,5,$date,0,0,'L');

      $this->Ln(5);
      $this->cell(20);


      $this->cell(80,5,$saddress,0,0,'L');

      $this->cell(35,5,'Purchase Order no.',0,0,'L');

      $this->cell(25,5,$_SESSION['pOrder'],0,0,'L');

      $this->Ln(20);

      $this->SetFont('Arial','U',10);
      $this->cell(80,5,'Description of materials',0,1);
      $this->SetFont('Arial','',10);

      //$this->Ln(10);
      $this->SetFont('Times','B','10');
      //$this->line(10, 105, 210-10, 105);
      $this->cell(30,10,'Item Code','T',0,'L');
      $this->line(10, 105, 210-8, 105);
      $this->cell(80,10,'Item Description','T',0,'L');
      $this->cell(30,10,'Unit Price','T',0,'L');
      $this->cell(30,10,'Qty.','T',0,'L');
      $this->cell(22,10,'Amount','T',1,'L');


      $this->SetFont('Times','B','10');

      $sql="SELECT `mid`,`qty`,`amount` FROM `purchase_orders` where `po_no`=".$_SESSION['pOrder']." ";
      $rowSQL1= mysqli_query($con,$sql);
      while($row1=mysqli_fetch_assoc( $rowSQL1))
      {
      $mno=$row1['mid'];
      $qty=$row1['qty'];
      $amt=$row1['amount'];
        $sql="SELECT `mid`,`Name` FROM `materials` where `mid`=$mno;";
        $rowSQL2= mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc( $rowSQL2))
        {
          $this->cell(30,10,$row['mid'],0,0,'L');
          $this->cell(80,10,$row['Name'],0,0,'L');
          $this->cell(30,10,$amt,0,0,'L');
          $this->cell(30,10,$qty,0,0,'L');
          $this->cell(15,10,$row1['amount'],0,1,'L');

        }
      }
          $this->Ln(10);

          //$this->line(10, 133, 210-10, 133);
          //$this->line(10, 140, 210-10, 140);
          $this->cell(110,10,'','T,B',0,'');
          $this->cell(10,10,'Total Rs.','T,B',0,'L');
          $this->cell(50,10,'','T,B',0,'');
          $this->cell(20,10,round($sum,2),'T,B',1,'L');


          $this->Ln(20);

          $this->cell(50,5,'..................................',0,0,'C');
          $this->cell(105,5,'..................................',0,0,'C');
          $this->cell(30,5,'..................................',0,1,'C');
          $this->cell(50,5,"Prepared by Emp no. $prpby",0,0,'C');
          $this->cell(105,5,"Approved by Emp no. $appby",0,0,'C');
            $this->cell(70,5,"Signature & stamp",0,'C');
          //$this->multicell(70,5,"Signature & stamp \n received the above items in \n good order & condition",0,'C');

          $this->Ln(20);

  }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->Output();

?>
<!--gima-->
