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
$j=0;
foreach ($jubilaeums->jubilare as $value) {
	$id = $value->id;
	$jubilaeum = json_decode(send_request('/jubilare.php/'.$id,'get'));


	if ($jubilaeum->mitglieder) {
		foreach ($jubilaeum->mitglieder as $value2) {
			$id2 = $value2->id;
			$mitglied = json_decode(send_request('/mitglieder.php/'.$id2,'get'));
			$result["aaData"]["mitglieder"][$j]["ID"] = $mitglied->ID;
			$result["aaData"]["mitglieder"][$j]["Nachname"] = $mitglied->Nachname;
			$result["aaData"]["mitglieder"][$j]["Vorname"] = $mitglied->Vorname;
			$result["aaData"]["mitglieder"][$j]["Strasse"] = $mitglied->Strasse;
			$result["aaData"]["mitglieder"][$j]["Hausnummer"] = $mitglied->Hausnummer;
			$result["aaData"]["mitglieder"][$j]["PLZ"] = $mitglied->PLZ;
			$result["aaData"]["mitglieder"][$j]["Ort"] = $mitglied->Ort;
			$result["aaData"]["mitglieder"][$j]["Ortsteil"] = $mitglied->Ortsteil;
			$result["aaData"]["mitglieder"][$j]["Geburstdatum"] = format_date($mitglied->Geburtsdatum);
			$result["aaData"]["mitglieder"][$j]["Alter"] = (int)$mitglied->Alter+1;
			$result["aaData"]["mitglieder"][$j]["Jubeltag"] = jubeltag($mitglied->Geburtsdatum,$mitglied->Alter);
			$j++;
		}
	}

	$result["treffer_mitglieder"] += $j;
	$result["treffer_jubilaeums"] = $i;
	$i++;
}
usort($result["aaData"]["mitglieder"], 'datums_vergleich');


$string .= "<table class='plist'>";

$string .= "<thead>";
$string .= "<tr>";
foreach ($result["aaData"]["mitglieder"][0] as $key => $value) {
	$string .= "<td class='lhead'>";
	$string .= $key;
	$string .= "</td>";
}
$string .= "</tr>";
$string .= "</thead>";

$string .= "<tbody>";
for ($j=0;$j<(count($result["aaData"]["mitglieder"]));$j++) {
	$string .= "<tr>";
	foreach ($result["aaData"]["mitglieder"][$j] as $key => $value) {
		$string .= "<td>";
		if ( $key=="Jubeltag" || $key=="Alter" ) { $string .= "<b>"; }
		$string .= $value;
		if ( $key=="Jubeltag" || $key=="Alter" ) { $string .= "</b>"; }
		$string .= "</td>";
	}
	$string .= "</tr>";
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

// Vergleichsfunktion
function datums_vergleich($wert_a, $wert_b) {
    // Sortierung nach dem zweiten Wert des Array (Index: 1)
	$arr_a = preg_split("/\./", $wert_a["Jubeltag"]);
	$arr_b = preg_split("/\./", $wert_b["Jubeltag"]);
	$a = (int)(strval($arr_a[2]).strval($arr_a[1]).strval($arr_a[0]));
	$b = (int)(strval($arr_b[2]).strval($arr_b[1]).strval($arr_b[0]));

    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : +1;
}

?>