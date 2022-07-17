<?php
require 'connection.php';

if (!isset($_SESSION['login_error']) || $_SESSION['login_error'] != 'ok' || !isset($_SESSION['id_user']) || $_SESSION['id_user'] == '' || !isset($_SESSION['id_department'])) {
    header('Location: auth.php');
    exit;
}

if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == 'ok' && isset($_SESSION['id_user']) && $_SESSION['id_user'] != '' && isset($_SESSION['id_department']) && $_SESSION['id_department'] != 0) {
    header('Location: indexOcean.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Праздник</title>
    <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>


<body>
    <div style="text-align: center">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 50px">
            <a class="navbar-brand">
                <h3 class="navbar m-auto">Здравствуйте, Администратор</h3>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropleft">
                        <a class="nav-link btn btn-outline-info btn-lg dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Начать работу
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if ($_SESSION['id_department'] == '0') : ?>
                                <!--<a class="dropdown-item" href="#">Рекорды</a>
                                <a class="dropdown-item" href="#">Участники</a>-->
                                <a class="dropdown-item" href="index.php">Игры</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="exit.php">Выйти</a>
                            <?php endif; ?>


                        </div>
                    </li>
                </ul>
            </div>


        </nav>
    </div>
    <?php
    $Rid_game = (int)$_POST['id_game'];
    $idDepartment = (int)$_POST['idDepartment'];
    $gameListDB = $mysql->prepare("SELECT name FROM  g22_game_list WHERE id_game= ?");
    $gameListDB->bind_param("i", $Rid_game);
    $gameListDB->execute();
    $gameListDB->bind_result($nameDB);
    while ($gameListDB->fetch()) {
    }
    ?>
    <div class="container-fluid">
        <h3 style="text-align: center; margin-top: 30px">Статистика игры <?php echo $nameDB ?></h3>
        <h3 style="text-align: center; margin-top: 30px"><?php if ($idDepartment == 0) {
                                                                echo "По всем локациям";
                                                            }
                                                            if ($idDepartment == 1) {
                                                                echo "Море Фридом";
                                                            }
                                                            if ($idDepartment == 2) {
                                                                echo "Консультантов пролив";
                                                            }
                                                            if ($idDepartment == 3) {
                                                                echo "Большой Контактный риф";
                                                            }


                                                            ?></h3>
        <div class="row" style="margin-top: 30px">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center">ID USER</th>
                            <th style="text-align: center">Логин</th>
                            <th style="text-align: center">Подразделение</th>
                            <th style="text-align: center">Рекорд</th>
                            <?php if ($Rid_game == 15 || $Rid_game == 18) { ?>
                                <th style="text-align: center">Время</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($Rid_game != 15 && $Rid_game != 18) {
                            if ($idDepartment == 0) {
                                $userDB = $mysql->prepare("SELECT U.id_user, U.login, U.id_department, R.score FROM  g22_user U, g22_rating R WHERE U.id_user=R.id_user AND R.id_game=? ORDER BY R.score DESC");
                                $userDB->bind_param("i", $Rid_game);
                            }
                            if ($idDepartment != 0) {
                                $userDB = $mysql->prepare("SELECT U.id_user, U.login, U.id_department, R.score FROM  g22_user U, g22_rating R WHERE U.id_user=R.id_user AND R.id_game=? AND U.id_department=? ORDER BY R.score DESC");
                                $userDB->bind_param("ii", $Rid_game, $idDepartment);
                            }
                            $userDB->execute();
                            $userDB->bind_result($id_userDB, $loginDB, $id_departmentDB, $scoreDB);
                        }
                        if ($Rid_game == 15 || $Rid_game == 18) {
                            if ($idDepartment == 0) {
                                $userDB = $mysql->prepare("SELECT U.id_user, U.login, U.id_department, R.score, R.time FROM  g22_user U, g22_rating R WHERE U.id_user=R.id_user AND R.id_game=? ORDER BY R.score DESC, R.time ASC");
                                $userDB->bind_param("i", $Rid_game);
                            }
                            if ($idDepartment != 0) {
                                $userDB = $mysql->prepare("SELECT U.id_user, U.login, U.id_department, R.score, R.time FROM  g22_user U, g22_rating R WHERE U.id_user=R.id_user AND R.id_game=? AND U.id_department=? ORDER BY R.score DESC, R.time ASC");
                                $userDB->bind_param("ii", $Rid_game, $idDepartment);
                            }
                            $userDB->execute();
                            $userDB->bind_result($id_userDB, $loginDB, $id_departmentDB, $scoreDB, $timeDB);
                        }


                        while ($userDB->fetch()) { ?>
                            <tr>
                                <td style="text-align: center"><?php echo $id_userDB ?></td>
                                <td style="text-align: center"><?php echo $loginDB ?></td>
                                <td style="text-align: center"><?php
                                                                if ($id_departmentDB == 1) {
                                                                    echo "Море Фридом";
                                                                }
                                                                if ($id_departmentDB == 2) {
                                                                    echo "Консультантов пролив";
                                                                }
                                                                if ($id_departmentDB == 3) {
                                                                    echo "Большой Контактный риф";
                                                                }
                                                                ?></td>
                                <td style="text-align: center"><?php echo $scoreDB ?></td>
                                <?php if ($Rid_game == 15 || $Rid_game == 18) { ?>
                                    <td style="text-align: center"><?php echo $timeDB ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>