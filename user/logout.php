<?php 
    // Initial session
    session_start();

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    header("location: login.php");
    exit;
?>
