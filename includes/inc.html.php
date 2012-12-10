<?php

function build_header($title="Start") {
	print 	'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<title>DJK Langenmosen: '.$title.'</title>
	<link rel="stylesheet" type="text/css" href="css/demo_table.css">
	<link rel="stylesheet" type="text/css" href="css/ui-custom/jquery-ui-1.7.2.custom.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.4.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.js"></script>
	<script type="text/javascript" src="js/jquery.ba-serializeobject.js"></script>
	<script type="text/javascript" src="js/json2.js"></script>
	<script type="text/javascript" src="js/download.jQuery.js"></script>
	';
	print "\n\n";
}

function build_body($menu="Start",$title="Start") {
		print 	'</head><body>';
		print "\n";
		print "<div class='container'>\n";
		print "<div class='title'>DJK Langenmosen - Mitgliederverwaltung | ".$title."</div>";
		print "<div class='stand'>Stand: ".date("d.m.Y",time())." - ".date("H:i",time())." Uhr</div>";
		print "<br style='clear:both;'>";
		print "<div id='menu'>\n";
		$active = (strcmp($menu, "Mitgliedertabelle")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='mitglieder.php'>Mitgliedertabelle</div>";
		$active = (strcmp($menu, "Listen")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='listen.php'>Listen</div>";
/*		$active = (strcmp($menu, "Beitr&auml;e")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='beitraege.php'>Beitr&auml;ge</div>";
*/		$active = (strcmp($menu, "Routen")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='routen.php'>Routen</div>";
/*		$active = (strcmp($menu, "Strassen")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='strassen.php'>Strassen</div>";
*/		$active = (strcmp($menu, "Statistik")!=0) ? "" : " active";
		print "<div class='menubutton".$active."' rel='statistik.php'>Statistik</div>";
		print "</div>\n";
		print "<div class='$menu'>\n";
}

function build_footer() {
	print "</div>\n";
	print "<br style='clear:both;'>";
  	print "</div>\n";
	print "<div class='copyright'>myVerein 0.1beta1 - &copy; 2010 DJK Langenmosen - Andreas Baierl</div>";
  	print "</body>\n</html>\n";
}

?>