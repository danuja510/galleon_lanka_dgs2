<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>createGTN</title>
    <script type="text/javascript">
      function validateDept(){
        var dept=document.getElementById("txtDept").value;
        if (dept=='__') {
          alert('Please Select A Department');
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
    <form  action="createGTN.php" method="post">
      <table>
        <tr>
          <td>
            <label for="txtDept">Select Department</label>
          </td>
        </tr>
        <tr>
          <td>
            <select name="txtDept" id="txtDept">
              <option value='__'>___</option>
              <option value='store'>Store</option>
              <option value='pfloor'>Production Floor</option>
              <option value='fGoods'>Finished Goods</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" name="btnNext" value="Next" onclick="validate()">
          </td>
        </tr>
      </table>
    </form>
    <?php
      if (isset($_POST['btnNext'])) {
        $_SESSION['dept']=$_POST['txtDept'];
        if ($_POST['txtDept']=='pfloor') {
          header('Location:GTNType.php');
        }else{
          if ($_POST['txtDept']=='store') {
            $_SESSION['gtntype']='out';
          }
          if ($_POST['txtDept']=='fGoods') {
            $_SESSION['gtntype']='in';
          }
          header('Location:stocksForGTN.php');
        }
      }
    ?>
  </body>
</html>
<!--dan-->
