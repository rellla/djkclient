<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings

// $params["amt"] = 100;
$result = "";
$string = "";
$i=0;

$mitglieder=json_decode(send_request('mitglieder.php/','get',$params));

$result["iTotalRecords"] = $mitglieder->count_all;
$result["iTotalDisplayRecords"] = $mitglieder->count_query;

$string .= $mitglieder->query;

if ($mitglieder->mitglieder) {
	foreach ($mitglieder->mitglieder as $value) {
		$id = $value->id;
		$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));

		$geb = preg_split("/-/", $mitglied->Alter);
		$alter = alter($geb[2],$geb[1],$geb[0]);
		$result["aaData"][$j]["ID"] = $mitglied->ID;
		$result["aaData"][$j]["Nachname"] = $mitglied->Nachname;
		$result["aaData"][$j]["Vorname"] = $mitglied->Vorname;
		$result["aaData"][$j]["Strasse"] = $mitglied->Strasse;
		$result["aaData"][$j]["Hausnummer"] = $mitglied->Hausnummer;
		$result["aaData"][$j]["PLZ"] = $mitglied->PLZ;
		$result["aaData"][$j]["Ort"] = $mitglied->Ort;
		$result["aaData"][$j]["Ortsteil"] = $mitglied->Ortsteil;
		$result["aaData"][$j]["Geburstdatum"] = format_date($mitglied->Geburtsdatum);
		$result["aaData"][$j]["Alter"] = (int)$mitglied->Alter+1;
		$result["aaData"][$j]["Jubeltag"] = jubeltag($mitglied->Geburtsdatum,$mitglied->Alter);
		$j++;
	}


	$result["treffer_mitglieder"] += $j;
	$result["treffer_jubilaeums"] = $i;
	$i++;
}

if (isset($params["amt"])) {
	$end = $params["amt"];
} else {
	$end = $result["iTotalDisplayRecords"];
}

usort($result["aaData"], 'datums_vergleich');


$string .= "<table class='plist'>";

$string .= "<thead>";
$string .= "<tr>";
foreach ($result["aaData"][0] as $key => $value) {
	$string .= "<td class='lhead'>";
	$string .= $key;
	$string .= "</td>";
}
$string .= "</tr>";
$string .= "</thead>";

$string .= "<tbody>";
for ($i=0;$i<$end;$i++) {
	$string .= "<tr>";
	foreach ($result["aaData"][$i] as $key => $value) {
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