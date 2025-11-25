<?php
$host = "localhost";
$user = "root";      
$password = "";       
$database = "user_form_db_chernikova";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}
?>