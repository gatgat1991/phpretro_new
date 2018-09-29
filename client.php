<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 PHPRetro. All rights reserved.
|| # http://www.PHPRetro.com
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
require_once('./includes/session.php');
$lang->addLocale("client.hotel");

if(isset($_SESSION['reauthenticate']) && $_SESSION['reauthenticate'] == "true"){
	$_SESSION['page'] = $_SERVER["REQUEST_URI"];
	header("Location: ".PATH."/account/reauthenticate"); exit;
}else{
	$user = new HoloUser($user->name,$user->password,true);
	$_SESSION['user'] = $user;
}

if(isset($_GET['wide']) && $_GET['wide'] == "false"){
	$wide = false;
	$width = "720";
	$height = "540";
}else{
	$wide = true;
	$width = "960";
	$height = "540";
}

//require_once('./templates/client_header.php');

$forwardid = $input->HoloText($_GET['forwardId']);
$roomid = $input->HoloText($_GET['roomId']);
$shortcut = $_GET['shortcut'];
switch($shortcut){
	case "roomomatic": $shortcut = "1"; break;
	default: unset($_GET['shortcut']); break;
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/css/hotel.css">
    <script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/swfobject.js"></script>
    <script type="text/javascript">
        var flashvars = {
            "avatareditor.promohabbos": "https://www.habbo.com/api/public/lists/hotlooks",
            "flash.client.origin": "popup",
            "client.notify.cross.domain": "1",
            "connection.info.host": "<?php echo $settings->find("hotel_ip"); ?>",
            "connection.info.port": "<?php echo $settings->find("hotel_port"); ?>",
            "site.url": "{{global_url}}",
            "url.prefix": "{{global_url}}",
            "client.reload.url": "{{global_url}}{{client_name}}",
            "client.fatal.error.url": "{{global_url}}/client/",
            "client.connection.failed.url": "{{global_url}}/client/",
            "logout.url": "{{global_url}}{{client_name}}",
            "logout.disconnect.url": "{{global_url}}{{client_name}}",
            "external.variables.txt": "http://swf.playfirst.ch/gamedata/external_variables.txt",
            "external.texts.txt": "http://swf.playfirst.ch/gamedata/external_flash_texts.txt",
            "external.figurepartlist.txt": "http://swf.playfirst.ch/gamedata/figuredata.xml",
            "external.override.texts.txt": "http://swf.playfirst.ch/gamedata/override/external_flash_override_texts.txt",
            "external.override.variables.txt": "http://swf.playfirst.ch/gamedata/override/external_override_variables.txt",
            "productdata.load.url": "http://swf.playfirst.ch/gamedata/productdata.xml",
            "client.starting.revolving": "For science, you monster/Loading funny message\u2026please wait./Would you like fries with that?/Follow the yellow duck./Time is just an illusion./Are we there yet?!/I like your t-shirt./Look left. Look right. Blink twice. Ta da!/It\'s not you, it\'s me./Shhh! I\'m trying to think here./Loading pixel universe.",
            "furnidata.load.url": "http://swf.playfirst.ch/gamedata/furnidata.xml",
            "sso.ticket": "<?php echo $user->user("ticket_sso"); ?>",
            "account_id": "<?php echo $user->user("id"); ?>",
            "client.allow.cross.domain": "1",
            "unique_habbo_id": "1",
            "flash.client.url": "http://swf.playfirst.ch/gordon/PRODUCTION-201601012205-226667486/",
            "user.hash": "{{user_hash}}",
            "supersonic_custom_css": "<?php echo PATH; ?>/web-gallery/css/sonic.css",
            "client.starting": "Plase Wait! {{hotel_name}} is Loading...",
            "supersonic_application_key": "2abb40ad",
            "has.identity": "1",
            "spaweb": "1",
        };
    </script>
    <script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/apinewhabbo.js"></script>
    <script type="text/javascript">
        var params = {
            "base": "http://swf.playfirst.ch/gordon/PRODUCTION-201601012205-226667486/",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };
        swfobject.embedSWF('http://swf.playfirst.ch/gordon/PRODUCTION-201601012205-226667486/habbo.swf', 'flash-container', '100%', '100%', '11.1.0', '<?php echo PATH; ?>/web-gallery/swf/expressInstall.swf', flashvars, params, null, null);
    </script>

</head>
<body>
<div id="client-ui">
    <div id="flash-wrapper">
        <div id="flash-container">
            <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                <p>FLASH NOT INSTALLED</p>

                <p><a href="https://www.adobe.com/go/getflashplayer"><img
                        src="<?php echo PATH; ?>/web-gallery/habbo-web/stuff/get_flash_player.png"
                        alt="Get Adobe Flash player"/></a></p>
            </div>
        </div>
    </div>
    <div id="content" class="client-content"></div>
    <iframe id="page-content" class="hidden" allowtransparency="true" frameBorder="0" src="about:blank"></iframe>
</div>
</body>
</html>
</script>
<?php require_once('./templates/client_footer.php');
?>