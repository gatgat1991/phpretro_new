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


$forwardid = $input->HoloText($_GET['forwardId']);
$roomid = $input->HoloText($_GET['roomId']);
$shortcut = $_GET['shortcut'];
switch($shortcut){
	case "roomomatic": $shortcut = "1"; break;
	default: unset($_GET['shortcut']); break;
}
?>


<html lang="de">
<head>
	<meta charset="utf-8">
	<title>habbo.CHAT: Hotel</title>

	<!-- CSS -->
	<script src="/cdn-cgi/apps/head/Fn0oZocRkXYBw8uVKDwhQQxE-U8.js"></script><link rel="stylesheet" href="//cdn.plyr.io/3.3.9/plyr.css">
	<link rel="stylesheet" href="https://habbo.chat/habbo-client/client.css" />

	<!-- JS -->
	<!--<script src="https://habbo.chat/habbo-client/flash_detect_min.js"></script>-->

	<!-- CLIENT -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://habbo.chat/habbo-client/swfobject.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
	<script type="text/javascript">
		function toggleFullscreen(event) {
			var element = document.body;

			if (event instanceof HTMLElement) {
				element = event;
			}

			var isFullscreen = document.webkitIsFullScreen || document.mozFullScreen || false;

			element.requestFullScreen = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || function () { return false; };
			document.cancelFullScreen = document.cancelFullScreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || function () { return false; };

			isFullscreen ? document.cancelFullScreen() : element.requestFullScreen();
		}
		
		var BaseUrl = "http://swf.playfirst.ch/gordon/PRODUCTION-201601012205-226667486/";
		var flashvars =
		{
            "external.texts.txt": "http://swf.playfirst.ch/gamedata/external_flash_texts.txt",
            "connection.info.port": "<?php echo $settings->find("hotel_port"); ?>",
            "furnidata.load.url": "http://swf.playfirst.ch/gamedata/furnidata.xml",
            "external.variables.txt": "http://swf.playfirst.ch/gamedata/external_variables.txt",
            "client.allow.cross.domain": "1",
            "url.prefix": "<?php echo PATH; ?>",
            "external.override.texts.txt": "http://swf.playfirst.ch/gamedata/override/external_flash_override_texts.txt",
            "supersonic_custom_css": "<?php echo PATH; ?>/web-gallery/css/hotel.css",
            "external.figurepartlist.txt": "http://swf.playfirst.ch/gamedata/figuredata.xml",
            "client.starting": "Los Los Habbo..",
            "processlog.enabled": "1",
            "has.identity": "1",
            "avatareditor.promohabbos": "https://www.habbo.com.br/api/public/lists/hotlooks",
            "productdata.load.url": "http://swf.playfirst.ch/gamedata/productdata.xml",
            "external.override.variables.txt": "http://swf.playfirst.ch/gamedata/override/external_override_variables.txt",
            "spaweb": "1",
            "connection.info.host": "<?php echo $settings->find("hotel_ip"); ?>",
            "sso.ticket": "<?php echo $user->user("ticket_sso"); ?>",
            "client.notify.cross.domain": "0",
            "account_id": "<?php echo $user->user("id"); ?>",
            "flash.client.url": "http://swf.playfirst.ch/gordon/PRODUCTION-201601012205-226667486/",
            "unique_habbo_id": "<?php echo $user->user("id"); ?>",
			"flash.client.origin" : "popup"
		};
		var params =
		{
			"base" : BaseUrl + "/",
			"allowScriptAccess" : "always",
			"menu" : "false"
		};
		swfobject.embedSWF(BaseUrl + "habbo.swf", "client", "100%", "100%", "11.1.0", "https://habbo.chat/habbo-client/flash/expressInstall.js", flashvars, params, null);
		//console.log('test');
//		$('#counter').show();
//		
//		var socket = io("https://socket_web.habbo.chat:8443");
//
//		socket.on('counter', (s) => {
//			$('#count').val(s);
//			console.log(s);
//		});
	
	</script>
</head>
<body>

	<ul class="client-btns">
		<li><a href="<?php echo PATH; ?>"><i>WEB</i></a></li>
		<!--<li id="counter"><span id="count">0</span></li>-->
		<li class="player" style="display: none">
			<span>
				<audio id="player" controls>
					<source src="//stream.ddosmichdo.ch/streams/1" type="audio/mp3">
					<source src="//stream.ddosmichdo.ch/streams/2" type="audio/aac">
				</audio>
			</span>
		</li>
		<li><span onclick="toggleFullscreen()"><i class="fas fa-expand"></i></span></li>
	</ul>
	<div id="client"></div>
	<div class="wrapper">
		<div class="client-error">
			<h1>Du benötigst Flash um Habbo zu spielen!</h1>
			<p>Wenn du über einen PC spielst, dann musst du <a href="https://www.adobe.com/go/getflashplayer" target="_blank">Flash zulassen, installieren oder aktualisieren.</a> Klicke <a href="https://www.adobe.com/go/getflashplayer" target="_blank">HIER</a> um Flash zu benutzen!</p>

			<p class="font_small">HINWEIS: Falls du Flash blockiert hast musst du deine Browsereinstellungen ändern und Flash zulassen, damit du spielen kannst.</p>
		</div>
	</div>
	<script defer src="//use.fontawesome.com/releases/v5.0.13/js/all.js"></script>

	
	<script src="//cdn.plyr.io/3.3.9/plyr.js"></script>
	<script>
		const player = new Plyr('#player', {
			controls: ['play', 'volume', 'mute'],
		});
	</script>

</body>
</html>
