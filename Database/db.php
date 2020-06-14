<?php
  function create_connection(){
    $con=mysqli_connect("localhost","root","","galleon_lanka");
    if(!$con)
    {
      die("cannot connect to DB server");
    }
    return $con;
  }

  function query_result($con, $sql){
    $rowSQL= mysqli_query($con,$sql);
    return mysqli_fetch_assoc($rowSQL);
  }
