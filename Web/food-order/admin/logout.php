<?php
    include('config/constants.php');
    session_destroy(); // Unset $_SESSION['user']
    //Redirect
    header('location:'.SITEURL.'admin/login.php');
?>