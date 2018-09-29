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
$lang->addLocale("landing.logout");

$user->destroy();
$reason = $_GET['reason'];

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";

require_once('./templates/login_header.php');


if($reason == ""){ 

}else{
switch($reason){
	case "banned":
		$reason = $lang->loc['logout.error.1'];
		break;
	case "concurrentlogin":
		$reason = $lang->loc['logout.error.2'];
		break;
	default:
		header("Location: ".PATH."/account/logout_ok");
		break;
}


} ?>

<div class="container content">
    <meta http-equiv="refresh" content="5;url=<?php echo PATH; ?>/index">
<div class="row">
    <div class="col-md-12">
        <div class="logout-jumbotron jumbotron">
            <div class="logout-jumbotron-content">
                <img src="<?php echo PATH; ?>frank-bye.png" class="pull-left" alt="Frank bye">                <h1>Bis Bald!</h1>
                <p>Schade, dass du uns schon verlässt. Wir freuen uns auf deinen nächsten Besuch!</p>
                <p>Du wirst automatisch auf die Startseite weitergeleitet, falls nicht klicke <a href="<?php echo PATH; ?>/index">hier</a> ... <img src="<?php echo PATH; ?>/loading-big.gif" alt="Loading ..."></p>
            </div>
        </div>
    </div>
</div>

<?php require('./templates/login_footer.php'); ?>