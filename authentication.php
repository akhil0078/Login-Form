<?php 
session_start();
include('./dbcon.php');

    if(!isset($_SESSION['authenticated']))
    {
        $_SESSION['status'] = "Please login to access dashboard";
        header("Location: login.php");
        exit(0);
    }

?>