<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Finished products</title>
    <script type="text/javascript">
        function validateBom(){
        {
          if(document.getElementById('lstBom').value=="-----")
          {
              alert("please select a BOM");
              return false;
          }
          else
              return true;
        }
      }

      function validateValue(){
        var v=document.getElementById('txtValue').value;
        if(!isNaN(v)){
          return true;
        }
        else {
          alert("enter a valid value");
          return false;
        }
      }

      function Validate(){
        if(validateBom() && validateValue()){
          alert("finished product added");
        }
        else {
          event.preventDefault();
        }

      }
    </script>
  </head>
  <body>
    <h1>add finished products</h1>
    <form class="" action="finishedproducts.php" method="post">
      <table>
        <tr>
          <td><label for="txtName">Name</label></td>
          <td><input type="text" name="txtName" id="txtName" value="" required></td>
        </tr>

        <tr>
          <td><label for="lstBom">BOM ID</label></td>
          <td>
            <select name="lstBom" id="lstBom">
              <option value='-----'>-----</option>
              <?php
                $sql="SELECT DISTINCT `bom_id` FROM `bom`;";
                $con = mysqli_connect("localhost","root","","galleon_lanka");
                if(!$con)
                {
                  die("Error while connecting to database");
                }
                $rowSQL= mysqli_query( $con,$sql);
      					while($row=mysqli_fetch_assoc( $rowSQL )){
                  echo "
                    <option value='".$row['bom_id']."'> ".$row['bom_id']." </option>
                  ";
                }
                mysqli_close($con);
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="txtValue">Value</label></td>
          <td><input type="text" name="txtValue" id="txtValue" value=""></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="btnSubmit" id="btnSubmit" value="Add" onclick="Validate()"></td>
        </tr>
      </table>

      <?php
  		if(isset($_POST["btnSubmit"])){
  			$name=$_POST["txtName"];
        $bom=$_POST["lstBom"];
        $val=$_POST["txtValue"];
        $con1=mysqli_connect("localhost","root","","galleon_lanka");
  			if(!$con1){
  				die("Cannot connect to DB server");
  			}
  			$sql1="INSERT INTO `finished_products` (`Name`, `bom_id`, `value`) VALUES ('".$name."', '".$bom."', '".$val."')";
  			mysqli_query($con1,$sql1);
  			mysqli_close($con1);
  			}
  	?>

    </form>
  </body>
</html>

<!--gima-->
