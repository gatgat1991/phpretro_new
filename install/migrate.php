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

session_start();
if($_SESSION['install_started'] != true || empty($_SESSION['install_started'])){ header('Location: ./index.php'); exit; }

require_once('./install_classes.php');

if(!empty($_SESSION['settings']['s_site_language'])){
	$lang = new HoloLocaleInstaller;
	$lang->addLocale("installer.main");
	$lang->addLocale("installer.errors");
	$continue = $lang->loc['continue'];
	$back = $lang->loc['back'];
}else{
	$continue = "Continue";
	$back = "Back";
}

require_once('./migrate_functions.php');

$page = (int) $_POST['page']; if(empty($page)){ $page = 1; }
if(!isset($_SESSION['settings'])){ $_SESSION['settings'] = array(); }

if(!empty($_POST['submit']) && $_POST['submit'] == $continue){
	foreach($_POST as $id => $value){
		if($id == "page"){ continue; }
		$_SESSION['settings'][$id] = $value;
	}
	switch($page){
		case 1:
			if(!isset($_POST['s_site_language']) || empty($_POST['s_site_language'])){
				$error = "You must select a valid language!";
			}
			require_once('../includes/version.php');
			$_SESSION['settings']['s_version'] = serialize(version());
			$lang = new HoloLocaleInstaller;
			break;
		case 2:
			if(!file_exists('../config.php')){
				$error = $lang->loc['error.no.config'];
			}
			break;
		case 3:
			foreach($_POST as $value){
				if(empty($value)){
					$error = $lang->loc['fill.all.fields'];
					break;
				}
			}
			if(writeConfig($_POST) == false){
				$error = $lang->loc['cannot.write.config'];
				break;
			}
			define('IN_HOLOCMS', true);
			require_once('../install/config.php');
			require_once('../includes/classes.php');
			$db = new $conn['main']['server']($conn['main']);
			if($db->connection == false){ $error = $lang->loc['cannot.connect.database']; break; }
			if(!empty($db->error)){ $error = $lang->loc['database.connection.error'].": ".$db->error; break; }
			break;
		case 4:
			header('Location: ./?installed=success'); exit;
			break;
	}
	if(!isset($error)){
		$page++;
	}
}elseif($_POST['submit'] == $back){
	$page--;
}

switch($page){
case 1:
$description = "Welcome to PHPRetro! This script will attempt to migrate existing HoloCMS data to the new PHPRetro format. This script is only compatible with HoloCMS 3.1.1.60 with Holograph Emulator. If you are using a previous version, please upgrade to revision 60 before continuing. MAKE SURE YOU BACKED UP YOUR DATABASE, WITHER THIS SCRIPT SUCCEEDS OR FAILS, ALL YOUR PREVIOUS HOLOCMS DATA WILL BE LOST! To begin, please choose your language. Please note that this is permanent and you cannot change it later without reinstalling and losing all data.";
$title = "Introduction";
$disable_back = true;
$form = '<input type="hidden" name="page" value="1" /><div class="installer-label white"><label for="s_site_language">Language:</label></div><select name="s_site_language" title="Install all language files to ./includes/languages" class="installer-input">';
if ($handle = opendir('../includes/languages')) {
    while (false !== ($file = readdir($handle))) {
    	if($file == "." || $file == ".."){ continue; }
    	if(substr($file,-4) != ".php"){ continue; }
    	$filename = '../includes/languages/'.$file;
        $fh = fopen($filename, 'r');
        $contents = fread($fh, filesize($filename));
        $lines = split("\n", $contents);
        $name = str_replace('Name: ','',$lines[2]);
        if(isset($_SESSION['settings']['s_site_language']) && $_SESSION['settings']['s_site_language'] == str_replace('.php','',$file)){ $selected = ' selected="true"'; }
        $form .= '<option value="'.str_replace('.php','',$file).'"'.$selected.'>'.$name.'</option>';
    }
    $form .= '</select>';
    closedir($handle);
}
break;
case 2:
$lang->addLocale("installer.check");
$description = $lang->loc['page.desc'];
$title = $lang->loc['page.title'];
$disable_back = true;
if(!function_exists('apache_get_version')){
	function apache_get_version(){
		$version = explode(" ",$_SERVER["SERVER_SOFTWARE"],3);
		if(!strstr($version,"Apache")){ return false; }else{ return true; }
	}
}
if(!function_exists('apache_get_modules')){
	function apache_get_modules(){
		return array();
	}
}
$passed['php_version'] = ((version_compare(PHP_VERSION, '5.0.0') < 0) ? false : true);
$passed['apache'] = (apache_get_version() ? true : false);
$passed['mod_rewrite'] = (in_array('mod_rewrite',apache_get_modules()) ? true : false);
$passed['premission_cache'] = (is_writable('../cache/') ? true : false);
$passed['premission_config'] = (is_writable('../install/') ? true : false);
$form = '<input type="hidden" name="page" value="2" />';
$form .= '<div class="installer-label white"><label><em>'.$lang->loc['php.version.met'].'</em></label>';
$form .= $passed['php_version'] ? '<div class="check passed">'.$lang->loc['passed'].'</div>' : '<div class="check failed">'.$lang->loc['failed'].'</div><p class="error">'.$lang->loc['php.version.met.error'].'</p>';
$form .= '<div class="installer-label white"><label><em>'.$lang->loc['web.server.met'].'</em></label>';
$form .= $passed['apache'] ? '<div class="check passed">'.$lang->loc['passed'].'</div>' : '<div class="check failed">'.$lang->loc['failed'].'</div><p class="error">'.$lang->loc['web.server.met.error'].'</p>';
$form .= '<div class="installer-label white"><label><em>'.$lang->loc['mod.rewrite.check'].'</em></label>';
$form .= $passed['mod_rewrite'] ? '<div class="check passed">'.$lang->loc['passed'].'</div>' : '<div class="check failed">'.$lang->loc['failed'].'</div><p class="error">'.$lang->loc['mod.rewrite.check.error'].'</p>';
$form .= '<div class="installer-label white"><label><em>'.$lang->loc['cache.folder.writable'].'</em></label>';
$form .= $passed['premission_cache'] ? '<div class="check passed">'.$lang->loc['passed'].'</div>' : '<div class="check failed">'.$lang->loc['failed'].'</div><p class="error">'.$lang->loc['cache.folder.writable.error'].'</p>';
$form .= '<div class="installer-label white"><label><em>'.$lang->loc['install.folder.writable'].'</em></label>';
$form .= $passed['premission_config'] ? '<div class="check passed">'.$lang->loc['passed'].'</div>' : '<div class="check failed">'.$lang->loc['failed'].'</div><p class="error">'.$lang->loc['install.folder.writable.error'].'</p>';
if(!$passed['apache'] || !$passed['mod_rewrite'] || !$passed['premission_config']){ $disable_continue = true; }
break;
case 3:
$lang->addLocale("installer.database");
require('../config.php');
if($encryption != "new"){ $error = $lang->loc['error.wrong.encryption']; }
if($enable_status_image == "1"){ $_SESSION['settings']['s_site_status_image'] = "2"; }else{ $_SESSION['settings']['s_site_status_image'] = "0"; }
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
$pos = strpos($pageURL,"/install");
$pageURL = substr($pageURL, 0, $pos);
$_SESSION['settings']['s_site_path'] = $pageURL;
$_SESSION['settings']['s_register_referral_rewards'] = $reward;
$_SESSION['settings']['s_site_c_images_path'] = $cimagesurl;
$_SESSION['settings']['s_site_badges_path'] = $badgesurl;
$_SESSION['settings']['s_email_verify_enabled'] = (int) $email_verify;
$_SESSION['settings']['s_email_verify_reward'] = $email_verify_reward;
if(!isset($_SESSION['settings']['db_prefix'])){ $_SESSION['settings']['db_prefix'] = "cms_"; }
if(!isset($_SESSION['settings']['db_server'])){ $_SESSION['settings']['db_server'] = "mysql"; }
if(!isset($_SESSION['settings']['db_host'])){ $_SESSION['settings']['db_host'] = $sqlhostname; }
if(!isset($_SESSION['settings']['db_port'])){ $_SESSION['settings']['db_port'] = "3306"; }
if(!isset($_SESSION['settings']['db_username'])){ $_SESSION['settings']['db_username'] = $sqlusername; }
if(!isset($_SESSION['settings']['db_password'])){ $_SESSION['settings']['db_password'] = $sqlpassword; }
if(!isset($_SESSION['settings']['db_name'])){ $_SESSION['settings']['db_name'] = $sqldb; }
$description = $lang->loc['page.desc.migrate'];
$title = $lang->loc['page.title'];
$form = '<input type="hidden" name="page" value="3" />';
$form .= '<div class="installer-label white"><label for="db_prefix">'.$lang->loc['table.prefix'].':</label></div><input type="text" class="installer-input" name="db_prefix" value="'.$_SESSION['settings']['db_prefix'].'" title="'.$lang->loc['table.prefix.desc'].'" /><br />';
$form .= '<div class="installer-label white"><label for="db_server">'.$lang->loc['database.server'].':</label></div><select class="installer-input" name="db_server" title="'.$lang->loc['database.server.desc'].'"><option value="mysql"'; if($_SESSION['settings']['db_server'] == "mysql"){ $form .= ' selected="true"'; }; $form .= '>MySQL</option><option value="pgsql"'; if($_SESSION['settings']['db_server'] == "pgsql"){ $form .= ' selected="true"'; }; $form .= '>PostgreSQL</option><option value="sqlite"'; if($_SESSION['settings']['db_server'] == "sqlite"){ $form .= ' selected="true"'; }; $form .= '>SQLite</option><option value="mssql"'; if($_SESSION['settings']['db_server'] == "mssql"){ $form .= ' selected="true"'; }; $form .= '>Microsoft SQL Server</option></select><br />';
$form .= '<div class="installer-label white"><label for="db_host">'.$lang->loc['database.host'].':</label></div><input type="text" class="installer-input" name="db_host" value="'.$_SESSION['settings']['db_host'].'" title="'.$lang->loc['database.host.desc'].'" /><br />';
$form .= '<div class="installer-label white"><label for="db_port">'.$lang->loc['database.port'].':</label></div><input type="text" class="installer-input" name="db_port" value="'.$_SESSION['settings']['db_port'].'" title="'.$lang->loc['database.port.desc'].'" /><br />';
$form .= '<div class="installer-label white"><label for="db_username">'.$lang->loc['database.username'].':</label></div><input type="text" class="installer-input" name="db_username" value="'.$_SESSION['settings']['db_username'].'" title="'.$lang->loc['database.username.desc'].'" /><br />';
$form .= '<div class="installer-label white"><label for="db_password">'.$lang->loc['database.password'].':</label></div><input type="password" class="installer-input" name="db_password" value="'.$_SESSION['settings']['db_password'].'" title="'.$lang->loc['database.password.desc'].'" /><br />';
$form .= '<div class="installer-label white"><label for="db_name">'.$lang->loc['database.name'].':</label></div><input type="text" class="installer-input" name="db_name" value="'.$_SESSION['settings']['db_name'].'" title="'.$lang->loc['database.name.desc'].'" />';
break;
case 4:
$lang->addLocale("installer.migrating");
$description = $lang->loc['page.desc'];
$title = $lang->loc['page.title'];
$form = '<input type="hidden" name="page" value="4" />';
$disable_back = true;
$installing = true;
break;
}

require_once('./installer_header.php');
?>
<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">
			<div id="header" class="clearfix">
				<h1><a href="#"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo $page; ?>/4</span> <?php echo $title; ?></li>
				</ul>
			</div>
			<div id="process-content">
		<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	    <form method="post" action="./migrate.php" autocomplete="off">

	        <div id="installer-column-left" >

            <div id="installer-section-left">
	            <div class="cbb clearfix gray">
	            	<div class="box-content">
	                	<div class="installer-description"><label><?php echo $description; ?></label></div>
		            </div>
	            </div>
	        </div>


        </div>
        <div id="installer-column-right">

            <div id="installer-section-right">
            <?php if(isset($error)){ ?>
            	<div class="installer-error">
                	<div class="rounded rounded-red">
                    	<?php echo $error; ?>
                	</div>
                </div>
            <?php } ?>
                <div class="rounded rounded-blue">
                    <h2 class="heading"><?php echo $title; ?></h2>

                    <fieldset id="installer-fieldset">
						<?php if(isset($form) && !empty($form)){ echo $form; } ?>
						<?php if($installing == true){ migrateDB(); } ?>
                    </fieldset>

                </div>
            </div>

            <div id="installer-buttons">
                <?php if(!$disable_continue){ ?><input type="submit" name="submit" value="<?php echo $continue; ?>" class="continue" id="installer-button-continue" /><?php } ?>
                <?php if(!$disable_back){ ?><input type="submit" name="submit" value="<?php echo $back; ?>" class="back" id="installer-button-back" /><?php } ?>

            </div>
	    </div>
    </form>
	
						
							
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<?php require_once('./installer_footer.php'); ?>