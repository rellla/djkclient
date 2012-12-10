<?php
require "includes/inc.html.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings

if (isset($_GET['id'])) { $id = $_GET['id']; } else { $id=1; };

build_header("Details Mitglied");
?>



<script>
	$(document).ready(function(){
	<?php include("includes/inc.jsonload.php"); ?>
	$('#mitglied').load('includes/edit_mitglied.php?id=<?php print($_GET['id']); ?>',
		function() {
		}
	);
});
</script>

<?php build_body("Mitgliedertabelle","Details Mitglied"); ?>


<div id="mitglied">
</div>

<?php build_footer(); ?>