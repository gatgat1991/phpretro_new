<?php
/*================================================================+\

|| # PHPRetro - An extendable virtual hotel site and management

|+==================================================================

|| # Copyright (C) 2009 PHPRetro. All rights reserved.

|| # http://code.google.com/p/phpretro

|| # Parts Copyright (C) 2009 Meth0d. All rights reserved.

|| # http://www.meth0d.org

|| # All images, scripts, and layouts

|| # Copyright (C) 2009 Sulake Ltd. All rights reserved.

|+==================================================================

|| # PHPRetro is provided "as is" and comes without

|| # warrenty of any kind. PHPRetro is free software!

|| # License: GNU Public License 3.0

|| # http://opensource.org/licenses/gpl-license.php

\+================================================================*/

require_once('./includes/core.php');
$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "frontpage";
if($user->id > 0){ header("Location:".PATH."/me"); }
if(isset($_GET['error'])){
	$errorno = $_GET['error'];
	if($errorno == 1){
		$login_error = $lang->loc['error.1'];
	} elseif($errorno == 2){
		$login_error = $lang->loc['error.1'];
	} elseif(isset($_GET['ageLimit']) && $_GET['ageLimit'] == "true"){
		$login_error = $lang->loc['error.5'];
	}
}
$username = $input->HoloText($_GET['username']);
$rememberme = $input->HoloText($_GET['rememberme']);
$pageto = $input->HoloText($_GET['page']);
if(!isset($_SESSION['login'])){
	$_SESSION['login']['enabled'] = true;
	$_SESSION['login']['tries'] = 0;
}
?>
<!DOCTYPE>
<html lang="de">
    <head>
        <title>Holo.ws - Das kostenlose Habbo Retro Hotel für Jugendliche</title>

        <script src="/web-gallery/js/U1YfBQqEOhADZ4kw9TNYjkceD2Q.js"></script><link rel="shortcut icon" href="<?php echo PATH; ?>/public/images/favicon.ico?2.0" type="image/vnd.microsoft.icon">
        <meta charset="UTF-8">
        <meta name="author" content="Revue">
        <meta name="viewport" content="width=device-width, initial-scale=0.8">
        <meta name="title" content="Habbo Hotel" />
        <meta name="description" content="Hier im Habbo Hotel für Teenager gibt es kostenlose Taler und Rares! Neben den Talern gibt es viele coole Events, damit das Habbo Hotel auch Spaß macht." />
        <meta name="language" content="de" />
        <meta name="robots" content="index, follow" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.1.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script>

        <script src="<?php echo PATH; ?>/web-gallery/js/sweetalert.js"></script>
        <link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/css/sweetalert.css">
        <link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/css/Index.css">
    </head>
    <body>
        <div class="container-fluid bg-white">
            <div class="login">
                <img src="<?php echo PATH; ?>/web-gallery/images/logo.png" class="logo" align="center">
                <h1>
                    <span class="useronline"><b></b> Holos online</span>
                    Holo Hotel
                </h1>

                <form action="<?php echo PATH; ?>/index" method="POST">
                    <b>Username:</b>
                    <input type="text" name="username" placeholder="Username">

                    <b>Passwort:</b>
                    <input type="password" name="password" placeholder="Passwort">
                    <div onClick="ResetPWAlert()" style="cursor: pointer;margin-bottom: 5px;font-size: 12px;text-align: right;">Passwort vergessen?</div>

                    <input type="submit" name="submit" value="Einloggen">
                </form>

                <a href="<?php echo PATH; ?>/register">
                    <div class="register">
                        Jetzt im Holo<br>
                        kostenlos registrieren!
                    </div>
                </a>
            </div>
        </div>
        <footer>
            &copy; 2011-2017 Holo Hotel<br>
            <span class="specialthanks">CentenaryCMS V5 - Credits to Revue</span>

            <div class="links">
            </div>
        </footer>
    </body>  

    <script>

        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-100554816-1', 'auto');
        ga('send', 'pageview');
        $(document).ready(function () {

            if (window.location.hostname !== 'habb0.ml')
            {
                window.location.href = "https://" + window.location.hostname + "/index";
            } else {
                $.get("./Infos.php")
                        .done(function (data)
                        {
                            $("span.useronline b").html(data.users);
                            if (data.loggedin != "Guest")
                            {
                                window.location.href = "<?php echo PATH; ?>/me";
                            }

                            if (data.maintenance == true)
                            {
                                window.location.href = "https://" + window.location.hostname + "/index";
                            }
                        });
            }

            $("a[href='https://retrocase.ch']").hide();
            $(".diashow").css("margin-left", $("body").width());
            $('.diashow').animate({
                left: "-<?php echo 26 * 292; ?>px"
            }, 120000);
        });
        function ResetPWAlert()
        {
            swal({
                title: "Passwort zurücksetzen",
                text: "Falls du dein Passwort vom Holo vergessen hast, kannst du es reseten. <br>Wir schicken dir eine E-Mail mit einem Link, darauf kannst du anschliessend dein Passwort ändern!",
                type: "input",
                html: true,
                showCancelButton: false,
                closeOnConfirm: false,
                inputPlaceholder: "Deine E-Mail Adresse",
                confirmButtonText: "E-Mail abschicken",
                showLoaderOnConfirm: true
            }, function (inputValue) {
                if (inputValue === false)
                    return false;
                if (inputValue === "") {
                    swal.showInputError("Du musst eine E-Mail eintragen!");
                    return false
                }

                $.post("<?php echo PATH; ?>/public/loader/index/pwforgot.php", {email: inputValue})
                        .done(function (data)
                        {
                            swal({
                                title: "Abgeschickt!",
                                text: "Es wurde eine E-Mail an: <b>" + inputValue + "</b> verschickt!",
                                type: "success",
                                html: true
                            });
                        });
            });
        }
    </script>
</html>