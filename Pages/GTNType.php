<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }else if (!isset($_SESSION['dept'])) {
   header('Location:createGTN.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TypeOfGTN</title>
    <script type="text/javascript">
      function validateType(){
        var type=document.getElementById("txtGTNType").value;
        if (type=='__') {
          alert('Please Select A Type');
          return false;
        }else{
          return true;
        }
      }
      function validate()
      {
        if(validateDept())
          {}
        else
          event.preventDefault();
      }
    </script>
  </head>
  <body>
    <form action="GTNType.php" method="post">
      <label for="txtGTNType">Select GTN Type</label>
      <select name="txtGTNType" id="txtGTNType">
        <option value="__">___</option>
        <option value="in">IN</option>
        <option value="out">OUT</option>
      </select>
    </form>
    <?php
      $_SESSION['gtntype']=$_POST['txtGTNType'];
      header('Location:stocksForGTN.php');
    ?>
  </body>
</html>
