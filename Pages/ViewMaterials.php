<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>view Materials</title>
  </head>
  <body>
    <form action="viewMaterials.php" method="post">
    <table>
      <thead>
        <th>
            MID
        </th>
        <th>
            Name
        </th>
        <th>
            Type
        </th>
        <th>
            Supplier ID
        </th>
        <th>
            value
        </th>
      </thead>

      <?php
     $con = mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con)
         {
          die("cannot connect to DB server");
         }
        $sql="SELECT * FROM `materials`;";
        $rowSQL= mysqli_query( $con,$sql);
        while($row = mysqli_fetch_array($rowSQL)){
echo "
     <tr>
       <td>
           ".$row['mid']."
       </td>
       <td>
           ".$row['Name']."
       </td>
       <td>
           ".$row['Type']."
       </td>
       <td>
           ".$row['sid']."
       </td>
       <td>
           ".$row['value']."
       </td>
       <td>

           <input type='submit' name='".$row['mid']."' value='edit'>

       </td>
     </tr>

";
   }

   mysqli_close($con);
   ?>

</table>
 </form>

 <?php

 $con1 = mysqli_connect("localhost","root","","galleon_lanka");
   if(!$con1)
     {
      die("cannot connect to DB server");
     }

    $sql="SELECT * FROM `materials`";
    $rowSQL= mysqli_query( $con1,$sql);

   while($row = mysqli_fetch_array( $rowSQL ))
   {
     if (isset($_POST[$row['mid']])) {
       $_SESSION['mid']=$row['mid'];
       header('Location:manageMaterials.php');
     }
   }
   mysqli_close($con1);

  ?>
</body>
</html>
<!--sithara-->
