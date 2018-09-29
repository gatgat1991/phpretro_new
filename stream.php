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

$page['allow_guests'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$data = new community_sql;
$lang->addLocale("community.tags");

$page['id'] = "tags";
$page['name'] = $lang->loc['pagename.tags'];
$page['bodyid'] = "tags";
$page['cat'] = "community";

require_once('./templates/community_header.php');


if (isset($_GET['tag'])) { $search = $input->FilterText($_GET['tag']); }else { $search = ''; }	
if (isset($_GET['pageNumber'])) 
{ 
   $pagenum = $input->FilterText($_GET['pageNumber']);
} 


?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							<h2 class="title">Stramer Info
							</h2>
						<div id="tag-related-habblet-container" class="habblet box-contents">

</div>
	
						
					</div>

				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				
				


</div>
<div id="column2" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							
<iframe src="https://player.twitch.tv/?channel=gatgat_tv" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="550"></iframe>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/community_footer.php'); ?>