<?php
DEFINE('HOST', 'localhost:3306');
DEFINE('USER', 'root');
DEFINE('PASS', '');
DEFINE('DATABASE', 'CityWatch');

$connect = mysqli_connect(HOST, USER, PASS, DATABASE); //OR die("Error connecting to database: ".mysqli_connect_error());
if($connect){
    $message = "Connected to database ".DATABASE;
}else{
    $message = "Failed to connect to database: ".mysqli_connect_error();
}
error_log(print_r($message, TRUE)); 
//print as error log instead of displaying on website

mysqli_set_charset($connect, 'utf8');
?>