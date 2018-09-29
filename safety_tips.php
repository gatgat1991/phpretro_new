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
require_once('./includes/session.php');
$data = new welcome_sql;
$lang->addLocale("community.welcome");

$page['id'] = "welcome";
$page['name'] = $lang->loc['pagename.welcome'];
$page['bodyid'] = "welcome";
$page['cat'] = "home";
require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div id="habbo-way-content">
    <table>
        <tr>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_0.png" alt=""/> <br/></td>
            <td><h4>Halte deine Personalangaben geheim </h4>
            Man weiß nie, mit wem man wirklich online spricht. Deshalb gebe niemals deinen realen Name, deine Adresse, Telefonnummer, Fotos oder Name deiner Schule weiter. Wenn du deine Personalien angibst, bist du gefährdet und riskierst, betrogen und schikaniert zu werden.
            </td>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_1.png" alt=""/> <br/></td>
            <td><h4>Schütze deine Privatsphäre </h4>
            Halte dein Skype, MSN, Facebook geheim. Du kannst nicht wissen, wohin das führen kann.
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_2.png" alt=""/> <br/></td>
            <td><h4>Gebe dem Druck Gleichaltriger nie nach </h4>
            Mache nichts, wobei du dich nicht wohlfühlst. Nur weil alle anderen es tun, heisst es nicht, dass du's auch musst!
            </td>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_3.png" alt=""/> <br/></td>
            <td><h4>Lass deine Kumpels Pixels bleiben </h4>
            Menschen sind nicht immer, was sie vorgeben zu sein. Wenn jemand dich auffordert, sich mit ihnen im realen Leben zu treffen, sage &quot;Nein, danke!&quot; und sag einem Moderator , deinen Eltern oder einem Erwachsenen deines Vertrauens Bescheid.
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_4.png" alt=""/> <br/></td>
            <td><h4>Hab keine Angst davor, etwas laut und deutlich zu sagen. </h4>
            Wenn dich jemand belästigt oder dich in <?php echo $pagename; ?> bedroht, melde das sofort einem Moderator über den Panikknopfes.
            </td>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_5.png" alt=""/> <br/></td>
            <td><h4>Banne die Webcam </h4>
            Du hast keine Kontrolle über deine Fotos und Webcam-Bilder, wenn du sie einmal im Internet geteilt hast und du kannst sie nicht zurückbekommen. Sie können von anderen jederzeit vergeben und überall verwendet werden, um dich zu schikanieren, zu erpressen oder bedrohen. Bevor du ein Bild postst, frage dich selbst, ob du dich wohl fühlen würdest, wenn andere Leute, die du nicht kennst, deine Bilder sehen können.
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo PATH; ?>/web-gallery/v2/images/safety/page_6.png" alt=""/> <br/></td>
            <td><h4>Sei ein schlauer Surfer </h4>
            Webseiten, die dir Taler, Furnis kostenlos anbieten oder sich als ein neues Hotel <?php echo $pagename; ?> oder Staff-Webseiten ausgeben, sind Betrügerseiten, die versuchen, dein Passwort zu stehlen. Gebe niemals deine Personalangaben weiter und lade keine Dateien herunter. Diese können Keyloggers oder Virus sein!
            </td>
        </tr>
    </table>
</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<script type="text/javascript">
HabboView.run();
</script>
<div id="column2" class="column">
</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
   
