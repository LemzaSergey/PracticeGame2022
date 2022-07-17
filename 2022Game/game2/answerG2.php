<?php
require '../connection.php';
$answer = $_POST['answer'];
$idGame = $_POST['idGame'];
$idUser = $_POST['idUser'];
$time_endE = time();
$double_game_event = 0;
$idGameRating = 2;

if ($idUser == $_SESSION['id_user']) {

    $eventSDB = $mysql->prepare("SELECT id_event FROM g22_game_event WHERE id_user =? AND id_game =?");
    $eventSDB->bind_param("ii", $idUser, $idGame);
    $eventSDB->execute();
    $eventSDB->bind_result($id_eventSDB);
    while ($eventSDB->fetch()) {
        $double_game_event = 1;
    }
    $eventSDB->close();



    $answerDB = $mysql->prepare("SELECT answer, link FROM g22_game2_answer WHERE id_game =?");
    $answerDB->bind_param("i", $idGame);
    $answerDB->execute();
    $answerDB->bind_result($resultANDB, $linkDB);

    while ($answerDB->fetch()) {
    }
    $answerDB->close();
    if ($resultANDB == $answer) {
        $answer = 1;
    } else {
        $answer = 0;
    }

    if ($double_game_event == 0) {
        $eventDB = $mysql->prepare("INSERT INTO g22_game_event (id_user, id_game, score, time_end) VALUES (?,?,?,?)");
        $eventDB->bind_param("iiii", $idUser, $idGame, $answer, $time_endE);
        $eventDB->execute();
        //echo "*INSERTEVENTDB*";
        $eventDB->close();


        $ratingSDB = $mysql->prepare("SELECT id_user, id_game, score FROM g22_rating WHERE id_user =? AND id_game =?");
        $ratingSDB->bind_param("ii", $idUser, $idGameRating);
        $ratingSDB->execute();
        $ratingSDB->bind_result($id_user_ratingSDB, $id_game_ratingSDB, $score_ratingSDB);
        while ($ratingSDB->fetch()) {
        }
        $ratingSDB->close();

        if ($id_user_ratingSDB) {
            if ($answer == 1) {
                $score_ratingSDB = $score_ratingSDB + 1;
            }

            $ratingUPDB = $mysql->prepare("UPDATE g22_rating SET score = ? WHERE id_user = ? AND id_game = ?");
            $ratingUPDB->bind_param("iii", $score_ratingSDB, $idUser, $idGameRating);
            $ratingUPDB->execute();
            //echo "*UPDATERATINGDB*";

        } else {
            $ratingINDB = $mysql->prepare("INSERT INTO g22_rating (id_user, id_game, score) VALUES (?,?,?)");
            $ratingINDB->bind_param("iii", $idUser, $idGameRating, $answer);
            $ratingINDB->execute();
            //echo "*INSERTRATINGDB*";
        }
    }
} ?>
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

    <link rel="stylesheet" href="style_indexGames2.css" type="text/css">
</head>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>

                <div class="modalBlockAnswer">
                    <div class="modalBlock-content">
                        <a href="indexGame2.php" class="ButtonGame"></a>
                        <iframe width="1200" height="675" src="<?php echo $linkDB ?>?rel=0&fs=0&modestbranding=1&iv_load_policy=3" title="YouTube video player" frameborder="0" allowfullscreen></iframe>

                    </div>
                </div>
            </div>
        </div>

</body>

</html>