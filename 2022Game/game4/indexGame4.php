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

    <script type="text/javascript">
        var idUser = <?php echo (int)$_SESSION['id_user']; ?>;
        var idGame = 18;
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" href="style_indexGames4.css" type="text/css">
</head>
<?php
$counter_game_event = 0;
$idUser = $_SESSION['id_user'];
$idGame = 18;
$eventSDB = $mysql->prepare("SELECT score FROM g22_game_event WHERE id_user =? AND id_game =?");
$eventSDB->bind_param("ii", $idUser, $idGame);
$eventSDB->execute();
$eventSDB->bind_result($scoreSDB);
while ($eventSDB->fetch()) {
    $counter_game_event = $counter_game_event + 1;
}
$eventSDB->close();

?>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">

                <?php if ($counter_game_event == 0) { ?>

                    <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>
                    <div class="ger modalBlockImage1"></div>
                    <div class="ger ger2 modalBlockImage2"></div>

                    <?php for ($i = 1; $i < 15; $i++) { ?>
                        <div class="difference<?php echo $i ?>" id="difference<?php echo $i ?>" hidden></div>
                        <div class="difference<?php echo $i ?>d" id="difference<?php echo $i ?>d" hidden></div>
                    <?php } ?>

                    <div class="modalBlockTime">
                        <div class="modalBlock-content">
                            <span class="time_pos"></span>

                        </div>
                    </div>
                    <div class="modalBlockDifference">
                        <div class="modalBlock-content">
                            <span class="difference_pos"></span>

                        </div>
                    </div>
                    <button class="ButtonSend" id="ButtonSend"></button>
                    <div class="modalBlockSendThanks">
                        <span class="ButtonSendThanks_pos"></span>
                    </div>
                <?php } else { ?>
                    <a href="/indexOcean.php" class="ButtonBathyscaphe2Thanks"></a>
                    <div class="modalBlockThanks">
                        <div class="modalBlock-content">
                            <h1>Спасибо за участие! Ваш результат <?php echo $scoreSDB; ?> секунд.</h1>
                        </div>
                    </div>


                <?php } ?>
            </div>
        </div>

    </div>


</body>

</html>