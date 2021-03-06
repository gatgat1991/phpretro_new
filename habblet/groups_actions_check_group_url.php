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

$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;
$lang->addLocale("groups.settings.checkurl");

$id = $input->FilterText($_POST['groupId']);
$url = $input->HoloText($_POST['url']);

if(strlen($url) > 30){ $error = true; }
$url_correct = $input->stringToURL($url,false,false);
if($url != $url_correct){ $error = true; }
if($serverdb->num_rows($data->select18($url)) > 0){ $error = true; }

if($error != true){
echo $lang->loc['your.alias']." ".PATH."/groups/".$url.". ".$lang->loc['you.cannot.alter'];
}else{
echo $lang->loc['url.error'];
}
?>
