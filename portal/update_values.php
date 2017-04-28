<?php
$sensor1=$_GET['sensor1'];
$sensor2=$_GET['sensor2'];
$sensor3=$_GET['sensor3'];
$pass=$_GET['pass'];
include (dirname(__FILE__) . '/config.php');
if ($pass == $service_secret && !empty($sensor1)){
    require_once('functions.php');
    add_SQL_line("INSERT INTO data (sensor1, sensor2, sensor3, date) VALUES ('$sensor1', '$sensor2', '$sensor3', NOW())");
}
else echo "Bad credentials";