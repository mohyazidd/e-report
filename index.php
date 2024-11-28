<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) { 
    header('Location:style/index.php');
}else{
    header('Location:auth/login.php');
}