<?php
    session_start();
    unset($_SESSION['eno']);
    header('Location:signIn.php');
