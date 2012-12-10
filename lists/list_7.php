<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings

//$params["amt"] = 10;
$result = "";
$string = "";

$result["treffer_mitglieder"] = 0;
$result["treffer_jubilaeums"] = 0;

$jubilaeums = json_decode(send_request('jubilare.php/','get',$params));

$i=0;
foreach ($jubilaeums->jubilare as $value) {
	$id = $value->id;
	$jubilaeum = json_decode(send_request('/jubilare.php/'.$id,'get'));

	$j=0;
	if ($jubilaeum->mitglieder) {
		foreach ($jubilaeum->mitglieder as $value2) {
			$id2 = $value2->id;
			$mitglied = json_decode(send_request('/mitglieder.php/'.$id2,'get'));

			$result["aaData"][$i]["jubilaeum"] = $id;
			$result["aaData"][$i]["mitglieder"][$j]["ID"] = $mitglied->ID;
			$result["aaData"][$i]["mitglieder"][$j]["Nachname"] = $mitglied->Nachname;
			$result["aaData"][$i]["mitglieder"][$j]["Vorname"] = $mitglied->Vorname;
			$result["aaData"][$i]["mitglieder"][$j]["Strasse"] = $mitglied->Strasse;
			$result["aaData"][$i]["mitglieder"][$j]["Hausnummer"] = $mitglied->Hausnummer;
			$result["aaData"][$i]["mitglieder"][$j]["PLZ"] = $mitglied->PLZ;
			$result["aaData"][$i]["mitglieder"][$j]["Ort"] = $mitglied->Ort;
			$result["aaData"][$i]["mitglieder"][$j]["Ortsteil"] = $mitglied->Ortsteil;
			$result["aaData"][$i]["mitglieder"][$j]["Geburstdatum"] = format_date($mitglied->Geburtsdatum);
			$result["aaData"][$i]["mitglieder"][$j]["Alter"] = (int)$mitglied->Alter+1;
			$result["aaData"][$i]["mitglieder"][$j]["Jubeltag"] = jubeltag($mitglied->Geburtsdatum,$mitglied->Alter);

			$j++;
		}
	}

	$result["treffer_mitglieder"] += $j;
	$result["treffer_jubilaeums"] = $i;
	$i++;
}

$string .= "<table class='plist'>";

$string .= "<thead>";
$string .= "<tr>";
foreach ($result["aaData"][0]["mitglieder"][0] as $key => $value) {
	$string .= "<td class='lhead'>";
	$string .= $key;
	$string .= "</td>";
}
$string .= "</tr>";
$string .= "</thead>";

$string .= "<tbody>";
for ($i=0;$i<(count($result["aaData"]));$i++) {
	$string .= "<tr>";
	$string .= "<td class='jubtrenner' colspan='".count($result["aaData"][$i]["mitglieder"][0])."'>".($result["aaData"][$i]["jubilaeum"]+1)." Jahre</td>";
	$string .= "</tr>";	
	for ($j=0;$j<(count($result["aaData"][$i]["mitglieder"]));$j++) {
		$string .= "<tr>";
		foreach ($result["aaData"][$i]["mitglieder"][$j] as $key => $value) {
			$string .= "<td>";
			$string .= $value;
			$string .= "</td>";
		}		
		$string .= "</tr>";
	}
}
$string .= "</tbody>";

$string .= "</table>";

echo $string;

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

function jubeltag($geb, $alter) {
	$arr = preg_split("/-/", $geb);
	$jubeln = $arr[2].".".$arr[1].".".((int)($arr[0])+(int)$alter+1);
	return $jubeln;
}

?>