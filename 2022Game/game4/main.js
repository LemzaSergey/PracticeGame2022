$(document).ready(function () {
    let difference = 0;

    let time = 0;
    const sTime = setInterval(function () {

        if (difference < 14) {
            time = time + 0.1;
        }
        if (difference == 14) {
            clearInterval(sTime);

            document.getElementById('ButtonSend').hidden = true;
            $(".ButtonSendThanks_pos").html("Спасибо за участие! Ваш результат " + difference + " отличий за " + Math.round(time) + " секунд.");

            var xhr = new XMLHttpRequest();
            var data = { "idUser": idUser, "idGame": idGame, "score": difference, "time": Math.round(time) };

            xhr.open('POST', 'dbRecordGame4.php', false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("R=" + JSON.stringify(data));
        }
        $(".time_pos").html("Time " + (time).toFixed(1));
        $(".difference_pos").html("Отличий найдено " + difference + " из 14");
    }, 100);

    $(".ButtonSend").click(function () {
        clearInterval(sTime);

        document.getElementById('ButtonSend').hidden = true;

        $(".ButtonSendThanks_pos").html("Спасибо за участие! Ваш результат " + difference + " отличий за " + Math.round(time) + " секунд.");

        var xhr = new XMLHttpRequest();
        var data = { "idUser": idUser, "idGame": idGame, "score": difference, "time": Math.round(time) };

        xhr.open('POST', 'dbRecordGame4.php', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("R=" + JSON.stringify(data));
    });


    $(".ger").click(function (e) {
        var relativeX = Math.round(e.pageX - $(this).offset().left);
        var relativeY = Math.round(e.pageY - $(this).offset().top);
        $(".x_pos").html("X = " + relativeX);
        $(".y_pos").html("Y = " + relativeY);

        var x1 = 463;
        var y1 = 197;
        var len = (relativeX - x1) * (relativeX - x1) + (relativeY - y1) * (relativeY - y1);
        if (len < 600) {
            document.getElementById('difference1').hidden = false;
            document.getElementById('difference1d').hidden = false;
            difference++;
            return;
        }

        var x2 = 365;
        var y2 = 255;
        var len = (relativeX - x2) * (relativeX - x2) + (relativeY - y2) * (relativeY - y2);
        if (len < 400) {
            document.getElementById('difference2').hidden = false;
            document.getElementById('difference2d').hidden = false;
            difference++;
            return;
        }

        var x3 = 370;
        var y3 = 450;
        var len = (relativeX - x3) * (relativeX - x3) + (relativeY - y3) * (relativeY - y3);
        if (len < 400) {
            document.getElementById('difference3').hidden = false;
            document.getElementById('difference3d').hidden = false;
            difference++;
            return;
        }

        var x4 = 455;
        var y4 = 490;
        var len = (relativeX - x4) * (relativeX - x4) + (relativeY - y4) * (relativeY - y4);
        if (len < 400) {
            document.getElementById('difference4').hidden = false;
            document.getElementById('difference4d').hidden = false;
            difference++;
            return;
        }

        var x5 = 465;
        var y5 = 400;
        var len = (relativeX - x5) * (relativeX - x5) + (relativeY - y5) * (relativeY - y5);
        if (len < 400) {
            document.getElementById('difference5').hidden = false;
            document.getElementById('difference5d').hidden = false;
            difference++;
            return;
        }

        var x6 = 100;
        var y6 = 165;
        var len = (relativeX - x6) * (relativeX - x6) + (relativeY - y6) * (relativeY - y6);
        if (len < 400) {
            document.getElementById('difference6').hidden = false;
            document.getElementById('difference6d').hidden = false;
            difference++;
            return;
        }

        var x7 = 165;
        var y7 = 515;
        var len = (relativeX - x7) * (relativeX - x7) + (relativeY - y7) * (relativeY - y7);
        if (len < 400) {
            document.getElementById('difference7').hidden = false;
            document.getElementById('difference7d').hidden = false;
            difference++;
            return;
        }

        var x8 = 530;
        var y8 = 530;
        var len = (relativeX - x8) * (relativeX - x8) + (relativeY - y8) * (relativeY - y8);
        if (len < 1200) {
            document.getElementById('difference8').hidden = false;
            document.getElementById('difference8d').hidden = false;
            difference++;
            return;
        }

        var x9 = 120;
        var y9 = 520;
        var len = (relativeX - x9) * (relativeX - x9) + (relativeY - y9) * (relativeY - y9);
        if (len < 1000) {
            document.getElementById('difference9').hidden = false;
            document.getElementById('difference9d').hidden = false;
            difference++;
            return;
        }

        var x10 = 245;
        var y10 = 520;
        var len = (relativeX - x10) * (relativeX - x10) + (relativeY - y10) * (relativeY - y10);
        if (len < 200) {
            document.getElementById('difference10').hidden = false;
            document.getElementById('difference10d').hidden = false;
            difference++;
            return;
        }

        var x11 = 240;
        var y11 = 545;
        var len = (relativeX - x11) * (relativeX - x11) + (relativeY - y11) * (relativeY - y11);
        if (len < 200) {
            document.getElementById('difference11').hidden = false;
            document.getElementById('difference11d').hidden = false;
            difference++;
            return;
        }

        var x12 = 580;
        var y12 = 190;
        var len = (relativeX - x12) * (relativeX - x12) + (relativeY - y12) * (relativeY - y12);
        if (len < 500) {
            document.getElementById('difference12').hidden = false;
            document.getElementById('difference12d').hidden = false;
            difference++;
            return;
        }
        var x13 = 105;
        var y13 = 310;
        var len = (relativeX - x13) * (relativeX - x13) + (relativeY - y13) * (relativeY - y13);
        if (len < 400) {
            document.getElementById('difference13').hidden = false;
            document.getElementById('difference13d').hidden = false;
            difference++;
            return;
        }

        var x14 = 333;
        var y14 = 95;
        var len = (relativeX - x14) * (relativeX - x14) + (relativeY - y14) * (relativeY - y14);
        if (len < 400) {
            document.getElementById('difference14').hidden = false;
            document.getElementById('difference14d').hidden = false;
            difference++;
            return;
        }


        time = time + 10;
    });

});

