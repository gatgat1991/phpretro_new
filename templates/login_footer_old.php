<div class="col-md-16 big-content">
	<div class="panel panel-default panel-blue">
			<div class="panel-heading">
			</div>
			<div class="panel-body">
				<div class="row">
				<?php
$lang->addLocale("ajax.tags");
$sql = $db->query("SELECT tag, COUNT(id) AS quantity FROM ".PREFIX."tags GROUP BY tag ORDER BY quantity DESC LIMIT 20");
if($db->num_rows($sql) < 1){ echo $lang->loc['no.tags']; }else{
	for($i=0;($array[$i] = @    $db->fetch_array($sql,1))!="";$i++)
        {
            $row[] = $array[$i];
        }
	sort($row);
	$i = -1;
	while($i <> $db->num_rows($sql)){
		$i++;
		if ( ! isset($row[$i]['tag'])
		or ! isset($row[$i]['quantity'])
	) 
	{
  		 $row[$i]['tag'] = null;
		 $row[$i]['quantity'] = null;
		}
		
		$tag = $row[$i]['tag'];
		$count = $row[$i]['quantity'];
		$tags[$tag] = $count;
	}
		
		$max_qty = max(array_values($tags));
		$min_qty = min(array_values($tags));
		$spread = $max_qty - $min_qty;

		if($spread == 0){ $spread = 1; }

		$step = (200 - 100)/($spread);

		foreach($tags as $key => $value){
		    $size = 100 + (($value - $min_qty) * $step);
		    $size = ceil($size);
		    echo "<a href=\"".PATH."/tag/".strtolower($input->HoloText($key))."\" class=\"tag\" style=\"font-size:".$size."%\">".trim(strtolower($key))."</a> \n";
		}


}
?>
				<center>

				</center>
				</div>
			</div>
		</div>
</div>    
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-grey footer">
            <div class="panel-heading">
                Powered by <a href="<?php echo PATH; ?>/index">Habb0</a> &copy; 2012-2018 | Raven and Waproks <span class="pull-right"><a href="http://status.daasdasdas.sdsadas" class="red" target="_blank">Status</a> | <a href="<?php echo PATH; ?>/index/impressum">Impressum</a> | <a href="<?php echo PATH; ?>/index/rules">Regeln</a> | <a href="<?php echo PATH; ?>/index/partner">Partner</a></span><div class="clear"></div>
            </div>
        </div>
    </div>
</div></div>        <script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/material.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/ripples.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/modernizr.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/relemon-lib.min.js?v7"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/web-gallery/js/relemon.min.js?v7"></script>
 


    </body>
</html>