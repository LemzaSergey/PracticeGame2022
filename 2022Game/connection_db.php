<?php
$host = "localhost";
$login = "l920402w_game22";
$password = "root2022GAME";
$dbname = "l920402w_game22";

//соединение с бд

$mysql = new mysqli($host, $login, $password, $dbname);

//$mysql->connect($server, $user, $pass, $dbname) or die("Sorry can't connect to mysql!");

$mysql->select_db($dbname) or die("Sorry can't connect to DB!");

if (!isset($_SESSION)) {
    session_start();
}
?>