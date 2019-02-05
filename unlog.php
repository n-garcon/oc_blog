<?php 

// Empty the SESSION variables
    session_start(); 
    $_SESSION[] = array();
    session_destroy();

// destroy the auto cookie connection
    setcookie("login", "");
    setcookie("password", "");

// return to login page 
    header("Location:index.php");
?>