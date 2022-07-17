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

    <link rel="stylesheet" href="style_indexRulesGames2.css" type="text/css">
</head>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <div class="ButtonCrab"></div>
                <a href="/indexOcean.php" class="ButtonBathyscaphe2"></a>
                
                <a href="indexGame2.php" class="ButtonGame"></a>
                <div class="modal">
                    <div class="modal-content">
                        <p>Проверим вашу интуицию, мужчины! Верите ли вы в то, что наши девушки умеют удивлять? :)</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>

</html>