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
//var_dump($_SESSION);
$highScoreDB = 0;
$idGameDB = 1;

$ratingSDB = $mysql->prepare("SELECT id_user, id_game, score FROM g22_rating WHERE id_user = ? AND id_game = ? ORDER BY score ASC");
$ratingSDB->bind_param("ii", $_SESSION['id_user'], $idGameDB);
$ratingSDB->execute();
$ratingSDB->bind_result($id_user_ratingSDB, $id_game_ratingSDB, $score_ratingSDB);

while ($ratingSDB->fetch()) {
    $highScoreDB = $score_ratingSDB;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>Sea Party</title>
    <script type="text/javascript">
        var idUser = <?php echo (int)$_SESSION['id_user']; ?>;
        var idGame = 1;
        var highScoreDB = <?php echo (int)$highScoreDB; ?>;
    </script>
    <link rel="stylesheet" href="style_indexGames1.css" type="text/css">
    <script id="gamedistribution-jssdk" src="https://html5.api.gamedistribution.com/main.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script src="lib/phaser.2.6.2.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico" media="all">
    <script src="src/main.js"></script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" id="gdsdk_google_analytics"></script>
    <script type="text/javascript" async="" crossorigin="anonymous" data-ad-client="ca-pub-2316275586951220" data-ad-frequency-hint="30s" data-ad-channel="4089988593" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" id="afg"></script>

</head>

<body class="modalBlockGame1">
    <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>


</body>

</html>