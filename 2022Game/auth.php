<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html style="height: 100%">

<head>
    <title>Авторизация</title>
    <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_auths.css" type="text/css">
</head>
<?php
if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == 'ok' && isset($_SESSION['id_user']) && $_SESSION['id_user'] != '' && isset($_SESSION['id_department']) && $_SESSION['id_department'] != '') {
    header('Location: index.php');
    exit;
}
if (isset($_SESSION['login_error'])) {
    if ($_SESSION['login_error'] == 'error') {
        echo ("<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\" style=\"text-align: center\">
                <strong>Ошибка!</strong> Проверьте правильность введённых данных 
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>");
        $_SESSION['login_error'] = 'no';
    }
    if ($_SESSION['login_error'] == 'login_busy') {
        echo ("<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\" style=\"text-align: center\">
                <strong>Ошибка!</strong> Извините, введённый вами логин уже зарегистрирован. Введите другой логин. 
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>");
        $_SESSION['login_error'] = 'no';
    }
    if ($_SESSION['login_error'] == 'registration_successful') {
        echo ("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" style=\"text-align: center\">
                <strong>Регистрация завершена успешна</strong>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>");
        $_SESSION['login_error'] = 'no';
    }
}
//var_dump($_SESSION);

?>

<body>
    <div class="ocean-room-body">
        <div class="ocean-room-page">
            <div class="ocean-room-centre-page">
                <div class="Mechanicscommon2"></div>
                <div class="modalBlock">
                    <div class="modalBlock-content">
                        <p>Дорогие Мужчины, заходите, поплаваем!</p>
                        <p>Устраивайтесь поудобнее, подводные приключения ждут вас!</p>
                    </div>
                </div>

                <div class="modalBlockRegistration">
                    <div class="modalBlockRegistration-content">
                        <div class="form-group" style="text-align: center">

                            <form method="POST" action="registration.php">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Введите ваше имя">

                                    <div class="optionsDepartment">
                                        <input type="radio" class="form-check-input optionsDepartment" style="margin-left: -2rem;" name="department" value="1" checked>Море Фридом
                                        <br />
                                        <input type="radio" class="form-check-input optionsDepartment" style="margin-left: -2rem;" name="department" value="2">Консультантов пролив
                                        <br />
                                        <input type="radio" class="form-check-input optionsDepartment" style="margin-left: -2rem;" name="department" value="3">Большой Контактный риф
                                        <!--
                                    <select name='department' class="custom-select optionsDepartment" style="font-family: Oceanfont" id="inputDepartment">
                                        <option disabled selected>Локация</option>
                                        <option value="1">Море Фридом</option>
                                        <option value="2">Консультантов пролив</option>
                                        <option value="3">Большой Контактный риф</option>
                                    </select>-->
                                        <br />

                                    </div>
                                    <button type="submit" class="ButtonRegistration"></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</body>

</html>