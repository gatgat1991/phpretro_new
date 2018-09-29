<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 Yifan Lu. All rights reserved.
|| # http://www.yifanlu.com
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
require_once('./includes/csrf.class.php');

$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);



if($settings->find("site_new_landing_page") == "1"){ require_once("./landing.php"); exit; }
$lang->addLocale("landing.login");

$data = new index_sql;

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";

if($user->id > 0){ header("Location:".PATH."/me"); }

if(!empty($_GET['error'])){
	$error = $input->HoloText($_GET['error']);
	if(!is_numeric($error)){ $error = 2; }
	$error = $lang->loc['error.'.$error];
}elseif(!empty($_SESSION['error'])){
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
}

if (isset($_GET['username'])) { $username = $input->HoloText($_GET['username']); }
if (isset($_GET['rememberme'])) { $rememberme = $input->HoloText($_GET['rememberme']); }
if (isset($_GET['page'])) { $pageto = $input->HoloText($_GET['page']); }

if(!isset($_SESSION['login'])){
	$_SESSION['login']['enabled'] = true;
	$_SESSION['login']['tries'] = 0;
}

require_once('./templates/login_header.php');
	
?>

<div class="container content">
    

<div class="row">
    <div class="col-md-8">
        <div class="login-jumbotron jumbotron">
            <div class="login-jumbotron-content">
                <h1>Habb0</h1>
                <p class="description">Willkommen im Habb0, eines der beliebtesten und meistbesuchten Retrohotels in Deutschland! Checke jetzt ein und überzeuge dich selbst.</p>
                <p><a href="<?php echo PATH; ?>/register" class="btn btn-material-lightblue btn-lg">Registriere<br />dich jetzt!</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default panel-blue">
            <div class="panel-heading">
                <h3 class="panel-title">Einloggen</h3>
            </div>
			

            <div class="panel-body">
                                <form action="<?php echo PATH; ?>/account/submit" class="login-form" method="POST" role="form">                <div style="display:none;">
                    </div>
								<?php
	if(isset($error)){
		echo "\n<div class=\"alert alert-danger\">\n ".$error."</div>\n";
	}
?>
                <div class="form-group">
                    <div class="input-group">
                        <label class="sr-only" for="login-username">Benutzername</label>
                        <div class="input-group-addon"><img src="<?php echo PATH; ?>/web-gallery/v2/img/user-login.png" alt="Benutzername"></div>
                        <input type="text" id="login-username" name="username" class="form-control" maxlength="30" autocomplete="off" placeholder="Benutzername">                    </div>
						<input type="hidden" name="<?php $token_id; ?>" value="<?php $token_value; ?>" />
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="sr-only" for="login-password">Password</label>
                        <div class="input-group-addon"><img src="<?php echo PATH; ?>/web-gallery/v2/img/key.png" alt="Passwort"></div>
                        <input type="password" id="login-password" name="password" class="form-control" maxlength="255" autocomplete="off" placeholder="Passwort">                    </div>
                </div>
				<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                <button type="submit" class="btn btn-block btn-raised btn-material-lightblue">Einloggen</button>
                </form>            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="<?php echo PATH; ?>/web-gallery/v2/img/Front1.png" alt="Freunde finden">            <div class="caption">
                <h3>Freunde finden</h3>
                <p>Finde neue und tolle Freunde im Habb0. Spiele oder chatte mit ihnen und habt Spaß miteinander!</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="<?php echo PATH; ?>/web-gallery/v2/img/Front3.png" alt="Events beitreten">            <div class="caption">
                <h3>Keine versteckten Kosten</h3>
                <p>Im Habb0 erhälst du jede 15 Minuten kostenlos Taler die du im Katalog ausgeben kannst, dass heißt du musst kein Geld für Taler ausgeben!</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="<?php echo PATH; ?>/web-gallery/v2/img/Front2.png" alt="Räume bauen">            <div class="caption">
                <h3>Räume bauen</h3>
                <p>Sammle und tausche deine Möbelstücke mit deinen Freunden oder anderen Mitspielern, um damit tolle Räume bauen zu können. Zeige deinen Mitspielern deine Errungenschaften!</p>
            </div>
        </div>
    </div>
</div>

<?php 
require_once('./templates/login_footer.php');
$dauer = microtime(true) - $beginn; 
echo "Verarbeitung des Skripts: $dauer Sek.";
 ?>
