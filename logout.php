<?php
require 'config/function.php';
session_start();
if(isset($_SESSION['loggedIn'])){
    logoutSession();
    redirect('index.php','logged out');

}

