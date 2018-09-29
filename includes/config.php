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

/*-------------------------------------------------------*\
| ****** NOTE REGARDING THE VARIABLES IN THIS FILE ****** |
+---------------------------------------------------------+
| If you get any errors while attempting to connect to    |
| MySQL, you will need to email your webhost because we   |
| cannot tell you the correct values for the variables    |
| in this file.                                           |
\*-------------------------------------------------------*/

//	****** MASTER DATABASE SETTINGS ******
//	These are the settings required to connect to your Database.
$conn['main']['prefix'] = "cms_";
$conn['main']['server'] = "mysql"; //mysql, pgsql, sqlite, or mssql
$conn['main']['host'] = "localhost"; //filename for SQLite
$conn['main']['port'] = "3306";
$conn['main']['username'] = "";
$conn['main']['password'] = "";
$conn['main']['database'] = "";

//	****** HOTEL DATABASE SETTINGS ******
//  EXPERIMENTAL!! Only turn this on if you know what to do. Please submit all
//  bugs and your fix for them (if possible) to http://code.google.com/p/phpretro
//	These are the settings required to connect to your hotel database Database.
$conn['server']['enabled'] = false;
$conn['server']['server'] = "mysql"; //mysql, pgsql, sqlite, or mssql
$conn['server']['host'] = "localhost"; //filename for SQLite
$conn['server']['port'] = "3306";
$conn['server']['username'] = "";
$conn['server']['password'] = "";
$conn['server']['database'] = "";
?>