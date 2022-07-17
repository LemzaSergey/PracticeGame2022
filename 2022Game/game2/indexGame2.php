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

    <link rel="stylesheet" href="style_indexGames2.css" type="text/css">
</head>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>
                <div class="modalBlock">
                    <div class="modalBlock-content">
                        <?php
                        $id_game = 3;
                        $game_eventDB = $mysql->prepare("SELECT id_game FROM g22_game_event WHERE id_user = ? AND id_game > 2 AND id_game < 15 ORDER BY id_game DESC");
                        $game_eventDB->bind_param("i", $_SESSION['id_user']);
                        $game_eventDB->execute();
                        $game_eventDB->bind_result($id_gameDB);

                        while ($game_eventDB->fetch()) {
                            $id_game = $id_gameDB + 1;
                            break;
                        }
                        $game_eventDB->close();
                        if ($id_game < 15) {
                            $active = 'no';
                            $game_listDB = $mysql->prepare("SELECT link FROM g22_game_list WHERE status=? AND id_game=?");
                            $game_listDB->bind_param('si', $active, $id_game);
                            $game_listDB->execute();

                            $game_listDB->bind_result($linkDB);

                            while ($game_listDB->fetch()) {
                            }
                            $game_listDB->close();


                        ?>
                            <iframe width="1200" height="675" src="<?php echo $linkDB ?>?rel=0&fs=0&modestbranding=1&iv_load_policy=3" title="YouTube video player" frameborder="0" allowfullscreen></iframe>

                            <div class="form-group" style="text-align: center">
                                <h1>Выберите ответ</h1>
                                <form method="POST" action="answerG2.php">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline ">
                                            <input type="radio" class="form-check-input" style="margin-top: 5px;" id="radio1" name="answer" value="1" checked>Верю
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" style="margin-top: 5px;" id="radio2" name="answer" value="0">Не верю
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>
                                        <input type="hidden" name="idGame" value="<?php echo $id_game ?>">
                                        <input type="hidden" name="idUser" value="<?php echo $_SESSION['id_user'] ?>">
                                        <button type="submit" class="ButtonSend"></button>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <h1 style="text-align: center">Вы ответили на все вопросы</h1>
                        <?php } ?>
                    </div>


                </div>
            </div>
        </div>

</body>

</html>