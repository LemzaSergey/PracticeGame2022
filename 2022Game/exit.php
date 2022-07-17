<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);
$_SESSION['id_user'] = null;
$_SESSION['surname'] = null;
$_SESSION['name'] = null;
$_SESSION['patronymic'] = null;
$_SESSION['login'] = null;
$_SESSION['id_department'] = null;
$_SESSION['login_error'] = 'no';

header('Location: auth.php');
exit;


