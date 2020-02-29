<?php
    session_start();
    if(!isset($_SESSION['eno'])){
      header('Location:signIn.php');
    }
    else if (!isset($_SESSION['eno2'])) {
    header('Location:viewEmployees.php');
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage employees</title>
  </head>

  <body>
    <?php
      $con = mysqli_connect("localhost","root","","galleon_lanka");
        if(!$con)
          {
           die("cannot connect to DB server");
          }
          $eno2=$_SESSION['eno2'];
         $sql="SELECT * FROM `employees` where `eno`='$eno2';";
         $rowSQL= mysqli_query( $con,$sql);
         $row = mysqli_fetch_assoc( $rowSQL);
    echo"
        <form action=\"manageEmployees.php\" method=\"post\">
        <table>

        <tr>
          <td>
            <label for='txtEno'>Eno</label>
          </td>
          <td>
            <input type='text' name='txtEno' id='txtEno' value=" .$row['eno']. " required readonly>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtName'>Name</label>
          </td>
          <td>
            <input type=\"text\" name=\"txtName\" id=\"txtName\" value=" .$row['Name']. " required>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtDes'>Designation</label>
          </td>
          <td>
            <input type=\"text\" name=\"txtDes\" id=\"txtDes\" value=" .$row['Designation']. " required readonly>
            <input type = \"button\" value=\"promote\">
          </td>
        </tr>

        <tr>
          <td>
            <label for='lstDepartment'>Department</label>
          </td>
          <td>
             <select name=\"lstDepartment\" id=\"lstDepartment\">

                 <option value=".$row['Dept'].">
                    ".$row['Dept']."
                 </option>

                 <option value=\"Store\">
                    Store
                 </option>

                 <option value=\"Production_floor\">
                    Production floor
                 </option>

                 <option value=\"Finished_goods\">
                    Finished goods
                 </option>

             </select>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtPwd'>Password</label>
          </td>
          <td>
            <input type=\"text\" name=\"txtPwd\" id=\"txtPwd\" value=" .$row['password']. " required>
          </td>
        </tr>

        <tr>
          <td>
            <label for='txtStatus'>Status</label>
          </td>
          <td>
            <input type=\"text\" name=\"txtStatus\" id=\"txtStatus\" value=" .$row['status']. " required readonly >
          </td>
        </tr>

        <tr>
          <td>
            <input type=\"submit\" name=\"btnUpdate\" id=\"btnUpdate\" value=\"update\">
          </td>
          ";


    mysqli_close($con);
     ?>

     <?php
     if(isset($_POST["btnUpdate"])){
       $name=$_POST["txtName"];
       $dep=$_POST["lstDepartment"];
       $pass=$_POST["txtPwd"];
       $con1=mysqli_connect("localhost","root","","galleon_lanka");
       if(!$con1){
         die("Cannot connect to DB server");
       }

       $sql1="UPDATE `employees` SET `Name` = '".$name."',`Dept`='".$dep."', `password` = '".$pass."' WHERE `eno` = '".$_SESSION['eno2']."'";
       mysqli_query($con1,$sql1);
       mysqli_close($con1);
       }
   ?>

   <?php
   if(isset($_POST["btnDelete"])){
     //echo "deleted";
     //$st=$_POST["txtStatus"];
     $con3=mysqli_connect("localhost","root","","galleon_lanka");
     if(!$con3){
       die("Cannot connect to DB server");
     }

     echo"
     <tr>
        <td>
     <script type= text/javascript>
     var sta=document.getElementById('txtStatus').value;
     if(sta=='active'){

         <input type='submit' name='btnDelete' id='btnDelete' value='delete'>

     }
     </script>
       </td>
     </tr>
     </table>
     </form>
     ";
      $sql3="UPDATE `employees` SET `status` = 'inactive' WHERE `eno` = '".$_SESSION['eno2']."'";

      mysqli_query($con3,$sql3);
      mysqli_close($con3);

      }


 ?>
  </body>
</html>
<!--gima-->
