<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2010 PHPRetro. All rights reserved.
|| # http://www.horro.co.uk
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
?>
<html>
	<head>
		<title>
			Attention Webmaster: Unresolved dependencies
		</title>	
	</head>
	<body>
		<h1>
			Unresolved dependencies
		</h1>
		Please install the following Apache modules:
		<p>
			<ul>
				<li>mod_rewrite</li>
				<li>mod_headers</li>
				<li>mod_deflate</li>
				<li>mod_expires</li>
			</ul>
		</p>
		This can be done in XAMPP by editing the httpd.conf file [C:\xampp\apache\conf\httpd.conf] and removing the '#' on the following lines:
		<br />
		LoadModule rewrite_module modules/mod_rewrite.so
		<br />
		LoadModule rewrite_module modules/mod_headers.so
		<br />
		LoadModule rewrite_module modules/mod_deflate.so
		<br />
		LoadModule rewrite_module modules/mod_expires.so
		<br />
		Or, you can use the httpd.conf file included in this package (located in the root folder upon extraction). If you are on a cPanel server, you can use easyapache to recompile Apache and PHP with these modules included.
		<br />
		If you are still having troubles, remove the last 35 lines from your .htaccess file
	</body>
</html>