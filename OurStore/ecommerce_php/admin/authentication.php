<?php
session_start();
include('../config/dbcon.php');

// If user are not authenticated, redirect user to index.php
if(!isset($_SESSION['auth'])){
    $_SESSION['message'] = "Login to Access Dashboard";
    header("Location: ../index/login.php");
    exit(0);
}
else
{
    if($_SESSION['auth_user']['user_id'] <= '29999')
    {
        $_SESSION['message'] = "You are not Authorised Admin";
        header("Location: ../customer/profile.php");
        exit(0);
    }
}

?>