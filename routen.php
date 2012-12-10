<?php
require_once "includes/inc.request.php";    // Request Routines
require_once "includes/inc.render.php";    // HTML Render Routines
require_once "includes/inc.html.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings

build_header();

?>
<script type="text/javascript">

$(document).ready(function(){
<?php
	include("includes/inc.jsonload.php");
?>
	$('#tabs').tabs({
		load: function(event,ui) {
		//	$('table.plist tbody tr:odd').addClass('odd');
		//	$('table.plist tbody tr:even').addClass('even');
			
		},
		selected: '-1'
	});
});


</script>
<?php
build_body("Routen");
?>

<div class="queryresult">
<div id="tabs">
	<ul>

<?php

$routen=json_decode(send_request('routen.php/','get'));
echo '<li><a href="routen/route.php?id=0" title="Listen"><span>nicht zugeordnet</span></a></li>';
for ($i=1;$i<$routen->count_query;$i++) {
	echo '<li><a href="routen/route.php?id='.($i).'" title="Listen"><span>Route '.($i).'</span></a></li>';
}
echo '<li><a href="routen/route.php?id=firma" title="Listen"><span>Firmen</span></a></li>';
echo '<li><a href="routen/route.php?id=alle" title="Listen"><span>Alle</span></a></li>';
?> 

	</ul>
<div id="Listen"></div>
</div>

</div>
<?php
build_footer();
?>