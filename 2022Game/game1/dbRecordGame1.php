<?php

require '../connection.php';

$json = json_decode($_POST["R"], true);
//var_dump($json);
echo $json["idUser"];
echo $json["idGame"];
echo $json["score"];
echo $json["highScore"];
//echo time();

$jsidUser = $json["idUser"];
$jsidGame = $json["idGame"];
$jsscore = $json["score"];
$jshighScore = $json["highScore"];

if ($json['idUser'] == $_SESSION['id_user']) {

    $eventDB = $mysql->prepare("INSERT INTO g22_game_event (id_user, id_game, score, time_end) VALUES (?,?,?,?)");
    $eventDB->bind_param("iiii", $jsidUser, $jsidGame, $jsscore, time());
    $eventDB->execute();
    echo "*INSERTEVENTDB*";

    if ($jsscore >= $jshighScore) {
        $ratingSDB = $mysql->prepare("SELECT id_user, id_game, score FROM g22_rating WHERE id_user =? AND id_game =?");
        $ratingSDB->bind_param("ii", $jsidUser, $jsidGame);
        $ratingSDB->execute();
        $ratingSDB->bind_result($id_user_ratingSDB, $id_game_ratingSDB, $score_ratingSDB);

        while ($ratingSDB->fetch()) {
            $ratingSDB->close();
            $ratingUPDB = $mysql->prepare("UPDATE g22_rating SET score = ? WHERE id_user = ? AND id_game = ?");
            $ratingUPDB->bind_param("iii", $jsscore, $jsidUser, $jsidGame);
            $ratingUPDB->execute();
            echo "*UPDATERATINGDB*";
            exit;
        }

        $ratingINDB = $mysql->prepare("INSERT INTO g22_rating (id_user, id_game, score) VALUES (?,?,?)");
        $ratingINDB->bind_param("iii", $jsidUser, $jsidGame, $jsscore);
        $ratingINDB->execute();
        echo "*INSERTRATINGDB*";
        exit;
    }
}
