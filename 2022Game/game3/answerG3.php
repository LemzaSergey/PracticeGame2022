<?php
require '../connection.php';

$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];

$time_start = $_POST['time_start'];
$time_end = time();

$idUser = $_SESSION['id_user'];
$idGame1 = 16;
$idGame2 = 17;
$idGameRating = 15;
$counter_game_event1 = 0;
$counter_game_event2 = 0;

$successful_game_event = 0;

//получаем ответы
$answer1DB = $mysql->prepare("SELECT link FROM g22_game_list WHERE id_game =?");
$answer1DB->bind_param("i", $idGame1);
$answer1DB->execute();
$answer1DB->bind_result($link1DB);

while ($answer1DB->fetch()) {
}
$answer1DB->close();
if ($answer1 == $link1DB) {
    $answer1 = 1;
} else {
    $answer1 = 0;
}

$answer2DB = $mysql->prepare("SELECT link FROM g22_game_list WHERE id_game =?");
$answer2DB->bind_param("i", $idGame2);
$answer2DB->execute();
$answer2DB->bind_result($link2DB);

while ($answer2DB->fetch()) {
}
$answer2DB->close();
if ($answer2 == $link2DB) {
    $answer2 = 1;
} else {
    $answer2 = 0;
}

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

if ($counter_game_event1 < 10) {
    //записали game_event
    $event1DB = $mysql->prepare("INSERT INTO g22_game_event (id_user, id_game, score, time_end, time_start) VALUES (?,?,?,?,?)");
    $event1DB->bind_param("iiiii", $idUser, $idGame1, $answer1, $time_end, $time_start);
    $event1DB->execute();
    $event1DB->close();


    $event2DB = $mysql->prepare("INSERT INTO g22_game_event (id_user, id_game, score, time_end, time_start) VALUES (?,?,?,?,?)");
    $event2DB->bind_param("iiiii", $idUser, $idGame2, $answer2, $time_end, $time_start);
    $event2DB->execute();
    $event2DB->close();


    //считаем количество успешных game_event
    $S_event1SDB = $mysql->prepare("SELECT score FROM g22_game_event WHERE id_user =? AND id_game =?");
    $S_event1SDB->bind_param("ii", $idUser, $idGame1);
    $S_event1SDB->execute();
    $S_event1SDB->bind_result($score_S_event1SDB);
    while ($S_event1SDB->fetch()) {
        if ($score_S_event1SDB == 1) {
            $successful_game_event = $successful_game_event + 1;
            break;
        }
    }
    $S_event1SDB->close();
    //var_dump($successful_game_event);
    $S_event2SDB = $mysql->prepare("SELECT score FROM g22_game_event WHERE id_user =? AND id_game =?");
    $S_event2SDB->bind_param("ii", $idUser, $idGame2);
    $S_event2SDB->execute();
    $S_event2SDB->bind_result($score_S_event2SDB);
    while ($S_event2SDB->fetch()) {
        if ($score_S_event2SDB == 1) {
            $successful_game_event = $successful_game_event + 1;
            break;
        }
    }
    $S_event2SDB->close();

    //var_dump($successful_game_event);

    //определяем значение rating
    $rating1SDB = $mysql->prepare("SELECT id_user, id_game, score, time FROM g22_rating WHERE id_user =? AND id_game =?");
    $rating1SDB->bind_param("ii", $idUser, $idGameRating);
    $rating1SDB->execute();
    $rating1SDB->bind_result($id_user_ratingSDB, $id_game_ratingSDB, $score_ratingSDB, $time_ratingSDB);
    while ($rating1SDB->fetch()) {
    }
    $rating1SDB->close();


    if ($id_user_ratingSDB) {
        $ratingTIME = $time_ratingSDB + $time_end - $time_start;
        $ratingUPDB = $mysql->prepare("UPDATE g22_rating SET score = ?, time=? WHERE id_user = ? AND id_game = ?");
        $ratingUPDB->bind_param("iiii", $successful_game_event, $ratingTIME, $idUser, $idGameRating);
        $ratingUPDB->execute();
        //echo "*UPDATERATINGDB*";
    } else {
        $ratingTIME = $time_end - $time_start;
        $ratingINDB = $mysql->prepare("INSERT INTO g22_rating (id_user, id_game, score, time) VALUES (?,?,?,?)");
        $ratingINDB->bind_param("iiii", $idUser, $idGameRating, $successful_game_event, $ratingTIME);
        $ratingINDB->execute();
        //echo "*INSERTRATINGDB*";
    }
}
header('Location: indexGame3.php');
