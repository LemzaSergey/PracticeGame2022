<?php
require '../connection.php';

if (!isset($_SESSION['login_error']) || $_SESSION['login_error'] != 'ok' || !isset($_SESSION['id_user']) || $_SESSION['id_user'] == '' || !isset($_SESSION['id_department'])) {
    header('Location: auth.php');
    exit;
}

if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == 'ok' && isset($_SESSION['id_user']) && $_SESSION['id_user'] != '' && isset($_SESSION['id_department']) && $_SESSION['id_department'] == 0) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ocean</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style_indexGames3.css" type="text/css">
</head>

<?php

$successful_game_event1 = 0;
$successful_game_event2 = 0;
$counter_game_event1 = 0;
$counter_game_event2 = 0;
$idUser = $_SESSION['id_user'];
$idGame1 = 16;
$idGame2 = 17;


//считаем количество успешных game_event
$S_event1SDB = $mysql->prepare("SELECT score FROM g22_game_event WHERE id_user =? AND id_game =?");
$S_event1SDB->bind_param("ii", $idUser, $idGame1);
$S_event1SDB->execute();
$S_event1SDB->bind_result($score_S_event1SDB);
while ($S_event1SDB->fetch()) {
    if ($score_S_event1SDB == 1) {
        $successful_game_event1 = $successful_game_event1 + 1;
        break;
    }
}
$S_event1SDB->close();
//var_dump($successful_game_event1);

$S_event2SDB = $mysql->prepare("SELECT score FROM g22_game_event WHERE id_user =? AND id_game =?");
$S_event2SDB->bind_param("ii", $idUser, $idGame2);
$S_event2SDB->execute();
$S_event2SDB->bind_result($score_S_event2SDB);
while ($S_event2SDB->fetch()) {
    if ($score_S_event2SDB == 1) {
        $successful_game_event2 = $successful_game_event2 + 1;
        break;
    }
}
$S_event2SDB->close();
//var_dump($successful_game_event2);

//считаем количество game_event
$event1SDB = $mysql->prepare("SELECT id_event FROM g22_game_event WHERE id_user =? AND id_game =?");
$event1SDB->bind_param("ii", $idUser, $idGame1);
$event1SDB->execute();
$event1SDB->bind_result($id_event1SDB);
while ($event1SDB->fetch()) {
    $counter_game_event1 = $counter_game_event1 + 1;
}
$event1SDB->close();

$event2SDB = $mysql->prepare("SELECT id_event FROM g22_game_event WHERE id_user =? AND id_game =?");
$event2SDB->bind_param("ii", $idUser, $idGame2);
$event2SDB->execute();
$event2SDB->bind_result($id_event2SDB);
while ($event2SDB->fetch()) {
    $counter_game_event2 = $counter_game_event2 + 1;
}
$event2SDB->close();
?>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>
                <div class="modalBlock">
                    <div class="modalBlock-content">
                        <?php if ($successful_game_event1 == 0 || $successful_game_event2 == 0) {
                        ?>
                            <?php if ($counter_game_event1 < 3 && $counter_game_event2 < 3) {
                            ?>
                                <div class="form-group" style="text-align: center">
                                    <h1>На забытом рыбьем языке словами записаны следующие числа:</h1>
                                    <div style="text-align: left; margin-left:240px; font-family: Calibri; font-style: normal;">
                                        <h1>57 &#160 osoto elano na ilano na itere</h1>
                                        <h1>82 &#160 osoto elano na emato na itere</h1>
                                        <h1>230 asa atere na osoto emato</h1>
                                        <h1>308 asa amato na ilano na imato</h1>
                                        <h1>705 asa alano na atere na ilano</h1>
                                    </div>
                                    <h1>Напишите на этом языке <?php if ($successful_game_event1 == 0) {
                                                                    echo '53';
                                                                } ?> <?php if ($successful_game_event1 == 0 && $successful_game_event2 == 0) {
                                                                            echo ' и ';
                                                                        } ?> <?php if ($successful_game_event2 == 0) {
                                                                                    echo '702';
                                                                                } ?></h1>
                                    <br />
                                    <form method="POST" action="answerG3.php">
                                        <div class="form-group" style="font-family: Calibri; font-style: normal;">
                                            <?php if ($successful_game_event1 == 0) {  ?>
                                                <input type="text" class="form-control" id="inputAnswer1" name="answer1" placeholder="53">
                                                <br />
                                            <?php }
                                            if ($successful_game_event2 == 0) { ?>
                                                <input type="text" class="form-control" id="inputAnswer2" name="answer2" placeholder="702">
                                            <?php } ?>
                                            <input type="hidden" name="time_start" value="<?php echo time() ?>">

                                            <button type="submit" class="ButtonSend"></button>
                                        </div>
                                    </form>
                                    <?php
                                    if ($counter_game_event1 == 0 && $counter_game_event2 == 0) {
                                    ?>
                                        <h2 style="color: #8a0850;">Будьте внимательны! У вас есть всего 3 попытки.</h2>
                                    <?php
                                    }
                                    if ($counter_game_event1 == 1 && $counter_game_event2 == 1) {
                                    ?>
                                        <h2 style="color: #8a0850;">Упс! Похоже ответ неверный. Попробуйте ещё!</h2>
                                    <?php
                                    }
                                    if ($counter_game_event1 == 2 || $counter_game_event2 == 2) {
                                    ?>
                                        <h2 style="color: #8a0850;">Осталась одна попытка!</h2>
                                    <?php
                                    }
                                    ?>

                                </div>
                            <?php
                            } else {
                            ?>
                                <h1 style="text-align: center;">Попытки кончились</h1>
                                <?php
                            } ?><?php
                            } else {
                                ?>
                                <h1 style="text-align: center;">Все правильно, вы мастер рыбьего языка</h1>
                            <?php
                            } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>