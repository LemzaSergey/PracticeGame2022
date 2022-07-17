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

    <link rel="stylesheet" href="style_indexRulesGames4.css" type="text/css">
</head>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <div class="ButtonFish1"></div>
                <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>
                
                <a href="indexGame4.php" class="ButtonGame"></a>
                <div class="modal">
                    <div class="modal-content">
                        <p>Для того, чтобы стать победителем этой игры, вам необходимо найти 14 отличий быстрее всех :) Важно знать, что при ошибочном клике на картинку прибавляется по 10 сек.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>

</html>