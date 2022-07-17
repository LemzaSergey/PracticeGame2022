<?php
$host = "127.0.0.1";
$login = "root";
$password = "";
$dbname = "game22";

//соединение с бд

$mysql = new mysqli($host, $login, $password, $dbname);

//$mysql->connect($server, $user, $pass, $dbname) or die("Sorry can't connect to mysql!");

$mysql->select_db($dbname) or die("Sorry can't connect to DB!");

if (!isset($_SESSION)) {
    session_start();
}
?>