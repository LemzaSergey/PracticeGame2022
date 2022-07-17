<?php

require '../connection.php';

$json = json_decode($_POST["R"], true);
//var_dump($json);
echo $json["idUser"];
echo $json["idGame"];
echo $json["score"];
echo $json["time"];
//echo time();

$jsidUser = $json["idUser"];
$jsidGame = $json["idGame"];
$jsscore = $json["score"];
$jstime = $json["time"];

if ($json['idUser'] == $_SESSION['id_user']) {

    $eventDB = $mysql->prepare("INSERT INTO g22_game_event (id_user, id_game, score, time_end, time_start) VALUES (?,?,?,?,?)");
    $eventDB->bind_param("iiiii", $jsidUser, $jsidGame, $jsscore, time(), $jstime);
    $eventDB->execute();
    echo "*INSERTEVENTDB*";

    $ratingINDB = $mysql->prepare("INSERT INTO g22_rating (id_user, id_game, score, time) VALUES (?,?,?,?)");
    $ratingINDB->bind_param("iiii", $jsidUser, $jsidGame, $jsscore, $jstime);
    $ratingINDB->execute();
    echo "*INSERTRATINGDB*";
    exit;
}
