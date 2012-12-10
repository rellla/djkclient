<?php

require "includes/inc.html.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings
require_once "includes/inc.request.php";    // Request Routines
require_once "includes/inc.render.php";    // HTML Render Routines

build_header();

?>
<script type="text/javascript">

$(document).ready(function(){
<?php
	include("includes/inc.jsonload.php");
?>
	$('#tabs').tabs({
		load: function(event,ui) {
			$('table.plist tbody tr:odd').addClass('odd');
			$('table.plist tbody tr:even').addClass('even');
			
		},
		selected: '-1'
	});
});


</script>
<?php
build_body("Listen");
?>

<div class="queryresult">
<div id="tabs">
     <ul>
         <li><a href="lists/list_1.php" title="Listen"><span>Hauptverein</span></a></li>
         <li><a href="lists/list_2.php" title="Listen"><span>Tennis</span></a></li>
         <li><a href="lists/list_3.php" title="Listen"><span>Stock</span></a></li>
         <li><a href="lists/list_4.php" title="Listen"><span>Gymnastik</span></a></li>
         <li><a href="lists/list_5.php" title="Listen"><span>M&auml;nnlich</span></a></li>
         <li><a href="lists/list_6.php" title="Listen"><span>Weiblich</span></a></li>
         <li><a href="lists/list_7.php" title="Listen"><span>Jubil&auml;um</span></a></li>
         <li><a href="lists/list_8.php" title="Listen"><span>Jubil&auml;um 2</span></a></li>
         <li><a href="lists/list_9.php" title="Listen"><span>Geburtstage</span></a></li>
		 <li><a href="lists/list_10.php" title="Listen"><span>Verstorben etc.</span></a></li>
	</ul>
	 <div id="Listen"></div>
</div>

</div>
<?php
build_footer();
?>