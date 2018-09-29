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
if (!defined("IN_HOLOCMS")) { header("Location: ".PATH."/"); exit; }
$lang->addLocale("landing.header");

?>
<!DOCTYPE html>
<html lang="de" class="no-js">
    <head>
	  <title>
         Habbo: Der Onlinechat f&uuml;r Jugendliche und Kinder. Finde neue Freunde!
      </title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Habbo, Habbohotel, Habb0hotel, chat f&uuml;r jugendliche, Lemon, MOD-Tool, Wired, gratis Taler, Habbo Hotel , virtuell, Welt, social network, community, avatar, chat, online, teen, Rollenspiel, anmelden, sozial, Gruppen, Foren, sicher, spielen, games, online, Freunde, teens, rares, rare M&ouml;bel, sammeln, erstellen, sammeln, treffen, M&ouml;bel, furni, Haustiere, Raum erstellen, teilen, Ausdruck, Badges, Treffpunkt, Musik, Stars, Starchats, HCs, mmo, mmorpg, massiv multiplayer">
		<meta name="description" content="Deutsches Habbo: Bei uns hast du 50000 Taler. Hier kannst du neue Freunde kennen lernen und eine menge Spa&szlig; haben. Der kostenlos online chat f&uuml;r Sch&uuml;ler, jugendliche, Kinder!">
		<meta name="DC.Description" content="50000 Starttaler, nette Community, Custom CMS, DDoS Schutz">
		<meta name="title" content="Habb0: Kostenlose Taler, Rares, Gruppen, Bots!">
		<meta name="robots" content="index,follow">
		<meta name="generator" content="">
		<meta name="rccount" content="<?php echo GetOnlineCount(); ?>">

		<link rel="shortcut icon" type="image/x-icon" href="<?php echo PATH; ?>/favicon.ico">
        <title>Habb0 :: Willkommen</title>
        <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/v2/styles/bootstrap.min.css?v2">
<link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/v2/styles/ripples.min.css?v2">
<link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/v2/styles/material.min.css?v2">
<link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/v2/styles/font-awesome.min.css?v2">
<link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>/web-gallery/v2/styles/relemon.min.css?v4">
<script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        
	
<div class="container-fluid navigation">
    <nav class="navbar navbar-navigation" role="navigation">
        <div class="container navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="web-gallery/v2/images/habbo.png" alt="Lemon Logo"></a>
            </div>
            <div class="navbar-collapse collapse" id="navigation-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <div class="online-user" id="online-user"><h4><strong><?php echo GetOnlineCount(); ?></strong> Online</h4></div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>