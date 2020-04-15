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
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/ManageStyles.css">
    <link rel="stylesheet" type="text/css" href="../StyleSheets/Select2Styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="../StyleSheets/Select3Styles.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
    <script type="text/javascript">

        /*function validateName(){
          var n=document.getElementById("txtName").value;
          if(n==null)
          {
              alert("please enter a name");
              return false;
          }
          else {
              return true;
          }
        }*/
        function validateBom(){
          if(document.getElementById('lstBom').value=="-----")
          {
              alert("please select a BOM");
              return false;
          }
          else{
              return true;
          }
      }

      function Validate(){
        if(validateBom() /*&& validateName()*/ )
        {}
        else {
          event.preventDefault();
        }
      }
    </script>
  </head>
  <body>
  <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
            <div class="row">
                <div class="btn-navi"><i class="ion-navicon-round"></i></div>
                <a href="empHome.php">
                    <div class="btn-home"><i class="ion-home"></i><p>Home</p></div>
                </a>
                <a href="logout.php">
                    <div class="btn-logout"><i class="ion-log-out"></i><p>Logout</p></div>
                </a>
                <a href="#"><div class="btn-account"><i class="ion-ios-person"></i><p>Account</p></div></a>
            </div>
        </div>
    </header>
    <section>
        <div class="row">
            <div class="col span-2-of-2">
            <form action="addFinishedProducts.php" method="post">
      <table>
        <tr>
          <td><label for="txtName">Name</label></td>
          <td><input type="text" name="txtName" id="txtName" value="" required></td>
        </tr>

        <tr>
          <td><label for="lstBom">BOM ID</label></td>
          <td>
            <select name="lstBom" id="lstBom" style='width:200px;'>
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
          <td><input type="number" name="txtValue" id="txtValue" value="" min="0" step="0.01" required> </td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Add" onclick="Validate()"></td>
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
  			$sql1="INSERT INTO `finished_products` (`Name`, `bom_id`, `value`,`status`) VALUES ('".$name."', '".$bom."', '".$val."','active')";
  			mysqli_query($con1,$sql1);
  			mysqli_close($con1);
  			}
  	?>

    </form>
            </div>
        </div>
    </section>
    <footer>
        <div class="row"><p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p></div>
        <div class="row"><p>Designed and Developed by DGS2</p></div>
    </footer>
  </body>
</html>

<!--gima-->
