<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>view cash receipt</title>
</head>
<body>
    <form action="viewCashreceipt.php">
    <table>
    <tr>
        <th>
          cr_no
        </th>
        <th>
          invoice no.
        </th>
        <th>
          c no.
        </th>
        <th>
          amount
        </th>
        <th>
          prepared by
        </th>
        <th>
          approved by
        </th>
        <th>
          remarks
        </th>
        <th>
          date
        </th>
    </tr>

    <?php
         $con=mysqli_connect("localhost","root","","galleon_lanka");
         if(!$con)
           {
             die("cannot connect to DB server");
           }

           $sql="SELECT * FROM `cash_receipts`";
           $rowSQL=mysqli_query($con,$sql);
           while($row=mysqli_fetch_array($rowSQL))
           {
   echo"
       <tr>
           <td>
               ".$row['cr_no']."
           </td>
           <td>
               ".$row['invoice_no']."
           </td>
           <td>
               ".$row['cno']."
           </td>
           <td>
               ".$row['amout']."
           </td>
           <td>
               ".$row['prepared_by']."
           </td>
           <td>
               ".$row['approved_by']."
           </td>
           <td>
               ".$row['remarks']."
           </td>
           <td>
               ".$row['date']."
           </td>
       </tr>
   ";
           }
       ?>
       </table>
       </form>

   </body>
   </html>
   <!--sithara-->
