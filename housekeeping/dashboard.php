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

$page['dir'] = '\housekeeping';
$page['housekeeping'] = true;
$page['rank'] = 5;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.dashboard");

if(isset($_POST['admin_notes'])){
	$db->query("UPDATE ".PREFIX."settings SET value = '".$input->FilterText($_POST['admin_notes'])."' WHERE id = 'hk_notes' LIMIT 1");
	$settings->generateCache();
	$message = $lang->loc['notes.saved'];
}

$page['name'] = $lang->loc['pagename.dashboard'];
$page['category'] = "dashboard";
$page['scrollbar'] = true;
$page['second_scrollbar'] = true;
require_once('./templates/housekeeping_header.php');
?>

<?php require_once('./templates/housekeeping_footer.php'); ?>