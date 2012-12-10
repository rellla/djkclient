<?php
require "includes/inc.request.php";    // Request Routines
require "includes/inc.render.php";    // HTML Render Routines
require "includes/inc.html.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings

build_header();

?>
<script type="text/javascript">


$(document).ready(function(){
<?php
	include("includes/inc.jsonload.php");
?>
	$('table.plist tbody tr:odd').addClass('odd');
	$('table.plist tbody tr:even').addClass('even');
});


</script>
<?php
build_body("Statistik");
?>

<div class="queryresult">
<?php

function print_stats_row ($title,$stats,$array) {
	$statistik = $array;
	$str_a_ges = eval('$ges = $statistik->Statistik->absolut->'.$stats.';return($ges);');
	$str_a_m = eval('$ges = $statistik->Statistik->absolut->'.$stats.'_m;return($ges);');
	$str_a_w = eval('$ges = $statistik->Statistik->absolut->'.$stats.'_w;return($ges);');
	$str_r_ges = eval('$ges = $statistik->Statistik->relativ->'.$stats.';return($ges);');
	$str_r_m = eval('$ges = $statistik->Statistik->relativ->'.$stats.'_m;return($ges);');
	$str_r_w = eval('$ges = $statistik->Statistik->relativ->'.$stats.'_w;return($ges);');

	$string .= "<tr>\n";
	$string .= "<td>";
	$string .= $title.":";
	$string .= "</td>\n";
	$string .= "<td>";
	$string .= $str_a_ges." &nbsp;&nbsp;&nbsp;<span class='prozent'>(".$str_r_ges."%)</span>";
	$string .= "</td>\n";
	$string .= "<td>";
	$string .= $str_a_m." &nbsp;&nbsp;&nbsp;<span class='prozent'>(".$str_r_m."%)</span>";
	$string .= "</td>\n";
	$string .= "<td>";
	$string .= $str_a_w." &nbsp;&nbsp;&nbsp;<span class='prozent'>(".$str_r_w."%)</span>";
	$string .= "</td>\n";
	$string .= "</tr>\n";
	
	return $string;
}

$statistik=json_decode(send_request('statistik.php/','get'));
$gesamtdb = $statistik->Statistik->absolut->Gesamtmitglieder;
$inaktiv = $gesamtdb - $statistik->Statistik->absolut->Gesamtmitglieder_aktiv;

$string = "<table class='plist'>\n";
$string .= "<thead>\n";
$string .= "<tr>\n";
	$string .= "<td class='lhead'>";
	$string .= "";
	$string .= "</td>\n";
	$string .= "<td class='lhead'>";
	$string .= "gesamt";
	$string .= "</td>\n";
	$string .= "<td class='lhead'>";
	$string .= "m&auml;nnlich";
	$string .= "</td>\n";
	$string .= "<td class='lhead'>";
	$string .= "weiblich";
	$string .= "</td>\n";
$string .= "</tr>\n";
$string .= "</thead>\n";

$string .= "<tbody>\n";

$string .= print_stats_row ("Mitglieder gesamt","Gesamtmitglieder_aktiv",$statistik);
$string .= print_stats_row ("Mitglieder Fu&szlig;ball","Fussballmitglieder",$statistik);
$string .= print_stats_row ("Mitglieder Tennis","Tennismitglieder",$statistik);
$string .= print_stats_row ("Mitglieder Stock","Stockmitglieder",$statistik);
$string .= print_stats_row ("Mitglieder Gymnastik","Gymnastikmitglieder",$statistik);
$string .= print_stats_row ("bis 5 Jahre","Alter0005",$statistik);
$string .= print_stats_row ("6-13 Jahre","Alter0613",$statistik);
$string .= print_stats_row ("14-17 Jahre","Alter1417",$statistik);
$string .= print_stats_row ("18-26 Jahre","Alter1826",$statistik);
$string .= print_stats_row ("27-40 Jahre","Alter2740",$statistik);
$string .= print_stats_row ("41-60 Jahre","Alter4160",$statistik);
$string .= print_stats_row ("&uuml;ber 60 Jahre","Alter6199",$statistik);

$string .= "<tr>\n<td colspan=4></br></td>\n</tr>\n";
$string .= "<tr>\n<td colspan=4>Gesamtmitglieder in DB: ".$gesamtdb."<br>Verstorben bzw. ausgetreten: ".$inaktiv."</td>\n</tr>\n";



$string .= "</tbody>";
$string .= "</table>";

echo $string;


?>
</div>
<?php
build_footer();
?>