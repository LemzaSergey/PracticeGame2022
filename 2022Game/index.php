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
                                <a class="dropdown-item" href="#">Игры</a>
                                <a class="dropdown-item" href="#">Участники</a>
                                <div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" href="exit.php">Выйти</a>
                            <?php endif; ?>


                        </div>
                    </li>
                </ul>
            </div>


        </nav>
    </div>
    <div class="container">
        <h1 style="text-align: center; margin-top: 30px">Игры</h1>
        <div class="row row-cols-1 row-cols-md-2">

            <?php
            $active = 'active';
            $game_listDB = $mysql->prepare("SELECT id_game, name, description, type, link, status, img FROM g22_game_list WHERE status=? ORDER BY id_game ASC");
            $game_listDB->bind_param('s', $active);
            $game_listDB->execute();

            $game_listDB->bind_result($id_game, $name, $description, $type, $link, $status, $img);
            while ($game_listDB->fetch()) {

            ?>
                <div class="col" style="margin-top: 30px">
                    <div class="card h-100">
                        <!--<img src="<?php echo 'image/' . $img ?>" class="card-img-top" style="max-height: 400px; width: 100%">-->
                        <div class="card-body">
                            <h3 class="card-title" style="text-align: center;"><?php echo $name ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="statistics_game.php" style="margin-bottom: 0px">
                                        <input type="hidden" name="idDepartment" value="0">
                                        <button type="submit" class="btn btn-info" style="width: 100%" name="id_game" value="<?php echo $id_game ?>">Статистика по всем локациям</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form method="POST" action="statistics_game.php" style="margin-bottom: 0px">
                                        <input type="hidden" name="idDepartment" value="1">
                                        <button type="submit" class="btn btn-info" style="width: 100%" name="id_game" value="<?php echo $id_game ?>">Статистика Море Фридом</button>
                                    </form>
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="statistics_game.php" style="margin-bottom: 0px">
                                        <input type="hidden" name="idDepartment" value="2">
                                        <button type="submit" class="btn btn-info" style="width: 100%" name="id_game" value="<?php echo $id_game ?>">Статистика Консультантов пролив</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form method="POST" action="statistics_game.php" style="margin-bottom: 0px">
                                        <input type="hidden" name="idDepartment" value="3">
                                        <button type="submit" class="btn btn-info" style="width: 100%" name="id_game" value="<?php echo $id_game ?>">Статистика Большой Контактный риф</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

</body>