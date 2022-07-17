<?php
require 'connection.php';

$login = $_POST['login'];

$userDB = $mysql->prepare("SELECT id_user, login, id_department FROM g22_user WHERE login =?");
$userDB->bind_param("ss", $login);

//$userDB = $mysql->prepare("SELECT id_user, surname, name, patronymic, login, password, id_department FROM g22_user");
$userDB->execute();
$userDB->bind_result($id_user, $login, $id_department);
while ($userDB->fetch()) {
    $_SESSION['id_user'] = $id_user;
    $_SESSION['login'] = $login;
    $_SESSION['id_department'] = $id_department;

    $_SESSION['login_error'] = 'ok';

    //var_dump($_SESSION);
    header('Location: index.php');
    exit;
}

$_SESSION['id_user'] = null;
$_SESSION['login'] = null;
$_SESSION['id_department'] = null;
$_SESSION['login_error'] = 'error';

header('Location: auth.php');
exit;
