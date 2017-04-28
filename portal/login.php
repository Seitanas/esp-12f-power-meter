<?php
include (dirname(__FILE__) . '/config.php');
require_once (dirname(__FILE__) . '/functions.php');

$username = $_POST['username'];
$password = $_POST['password'];
if ($username == $portal_username && $password == $portal_password){
    if (session_status() == PHP_SESSION_NONE)
	session_start();
    $_SESSION['logged']='yes';
    header ("Location: dashboard.php");
}
else
    header ("Location: /");