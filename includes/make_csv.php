<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings
header("Content-Type: text/txt");
header("Content-Disposition: attachment; filename=\"mitgliederliste.txt\"");

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // POST Request
	if (isset($_REQUEST['content'])) {
		$input = $_REQUEST['content'];
	}

	$res = json_decode($input);

	$i=0;
	$str ="";
	$sep = ",";

	if ($res->aaData) {
		foreach ($res->aaData as $value) {
			$id = $value->ID;
			$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));
			$geb = preg_split("/-/", $mitglied->Alter);
			$alter = alter($geb[2],$geb[1],$geb[0]);
			
			$result["aaData"][$i]["Nachname"] = utf8_decode($mitglied->Nachname);
			$result["aaData"][$i]["Vorname"] = utf8_decode($mitglied->Vorname);
			$result["aaData"][$i]["Geschlecht"] = $mitglied->Geschlecht;
			$result["aaData"][$i]["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
			
			$i++;
		}
	}

	foreach ($result["aaData"] as $value) {
		$str .= $value["Nachname"].$sep;
		$str .= $value["Vorname"].$sep;
		$str .= $value["Geschlecht"].$sep;
		$str .= $value["Geburtsdatum"]."\n";
	}
	echo $str;

}

// Functions
function alter($tag, $monat, $jahr) {
	if (!checkdate($monat, $tag, $jahr)) {
		return false;
	}
	$alter = date('Y') - $jahr;
	if (date('n') < $monat || (date('n') == $monat && date('j') < $tag)) {
		$alter--;
	}
	return $alter;
}

?>