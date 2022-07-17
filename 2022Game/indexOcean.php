<?php
require 'connection.php';

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

    <link rel="stylesheet" href="style_indexOceans.css" type="text/css">
</head>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <a href="game2/indexRulesGame2.php" class="ButtonCrab"></a>
                <a href="game4/indexRulesGame4.php" class="ButtonFish1"></a>
                <a href="game3/indexRulesGame3.php" class="ButtonFish2"></a>
                <a href="game1/indexRulesGame1.php" class="ButtonHorse"></a>
                <div class="ButtonBathyscaphe2"></div>
                <a href="exit.php" class="ButtonExit"></a>
                <div class="modal">
                    <div class="modal-content">
                        <p>Приглашаем вас немного отдохнуть и погрузиться в удивительный мир рыбов!</p>
                        <p>Попробуйте себя в различных испытаниях, становитесь лучшими и выигрывайте заслуженные призы!</p>
                    </div>
                </div>
                <div class="modalBlockExit">
                    <div class="modalBlockExit-content">
                        <p>Выйти</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>