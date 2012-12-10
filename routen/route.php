<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require "../includes/inc.html.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings

$id = $_REQUEST['id'];
$mitglieder_gesamt = 0;
$mitglieder_leben = 0;
	
if ($id=="firma") {
	$strassen=json_decode(send_request('routen.php/'.$id,'get'));
	for ($i=0;$i<$strassen->count_all;$i++) {
		$j=0;

		$sid = $strassen->Strassen[$i]->id;
		$strasse=json_decode(send_request('strassen.php/'.$sid,'get'));
		$arr["Strasse"][$i]["Strassenname"] = $strasse->Strasse->Name;
		$mitglieder=json_decode(send_request('strassen.php/'.$sid.'/mitglieder','get'));
		if ($mitglieder->Mitglieder) {
			foreach ($mitglieder->Mitglieder as $value) {
				$mid = $value->id;
				$mitglied = json_decode(send_request('/mitglieder.php/'.$mid,'get'));
				if ($mitglied->Firma == "1") {
					$arr["Strasse"][$i]["Mitglieder"][$j]["ID"] = $mitglied->ID;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Nachname"] = $mitglied->Nachname;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Vorname"] = $mitglied->Vorname;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Strasse"] = $mitglied->Strasse;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Hausnummer"] = $mitglied->Hausnummer;
					$arr["Strasse"][$i]["Mitglieder"][$j]["PLZ"] = $mitglied->PLZ;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Ort"] = $mitglied->Ort;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Ortsteil"] = $mitglied->Ortsteil;
					$arr["Strasse"][$i]["Mitglieder"][$j]["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
					$arr["Strasse"][$i]["Mitglieder"][$j]["Alter"] = $mitglied->Alter;
					if ($mitglied->Firma == "1") { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = "ja"; } else { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = ""; }
					$arr["Strasse"][$i]["Mitglieder"][$j]["Status"] = $mitglied->Status;
					$j++;
					$mitglieder_gesamt++;
				}
			}
		}
	}
} elseif ($id=="alle") {
	$strassen=json_decode(send_request('routen.php/'.$id,'get'));
	for ($i=0;$i<$strassen->count_all;$i++) {
		$j=0;

		$sid = $strassen->Strassen[$i]->id;
		$strasse=json_decode(send_request('strassen.php/'.$sid,'get'));
		$arr["Strasse"][$i]["Strassenname"] = $strasse->Strasse->Name;
		$mitglieder=json_decode(send_request('strassen.php/'.$sid.'/mitglieder','get'));
		if ($mitglieder->Mitglieder) {
			foreach ($mitglieder->Mitglieder as $value) {
				$mid = $value->id;
				$mitglied = json_decode(send_request('/mitglieder.php/'.$mid,'get'));
				$arr["Strasse"][$i]["Mitglieder"][$j]["ID"] = $mitglied->ID;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Nachname"] = $mitglied->Nachname;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Vorname"] = $mitglied->Vorname;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Strasse"] = $mitglied->Strasse;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Hausnummer"] = $mitglied->Hausnummer;
				$arr["Strasse"][$i]["Mitglieder"][$j]["PLZ"] = $mitglied->PLZ;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Ort"] = $mitglied->Ort;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Ortsteil"] = $mitglied->Ortsteil;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
				$arr["Strasse"][$i]["Mitglieder"][$j]["Alter"] = $mitglied->Alter;
				if ($mitglied->Firma == "1") { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = "ja"; } else { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = ""; }
				$arr["Strasse"][$i]["Mitglieder"][$j]["Status"] = $mitglied->Status;
				$j++;
				$mitglieder_gesamt++;
			}
		}
	}
} else {
	$strassen=json_decode(send_request('routen.php/'.$id,'get'));
	for ($i=0;$i<$strassen->count_all;$i++) {
		$j=0;

		$sid = $strassen->Strassen[$i]->id;
		$strasse=json_decode(send_request('strassen.php/'.$sid,'get'));
		$arr["Strasse"][$i]["Strassenname"] = $strasse->Strasse->Name;
		$mitglieder=json_decode(send_request('strassen.php/'.$sid.'/mitglieder','get'));
		if ($mitglieder->Mitglieder) {
			foreach ($mitglieder->Mitglieder as $value) {
				$mid = $value->id;
				$mitglied = json_decode(send_request('/mitglieder.php/'.$mid,'get'));
				$arr["Strasse"][$i]["Mitglieder"][$j]["ID"] = $mitglied->ID;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Nachname"] = $mitglied->Nachname;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Vorname"] = $mitglied->Vorname;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Strasse"] = $mitglied->Strasse;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Hausnummer"] = $mitglied->Hausnummer;
				$arr["Strasse"][$i]["Mitglieder"][$j]["PLZ"] = $mitglied->PLZ;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Ort"] = $mitglied->Ort;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Ortsteil"] = $mitglied->Ortsteil;
				$arr["Strasse"][$i]["Mitglieder"][$j]["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
				$arr["Strasse"][$i]["Mitglieder"][$j]["Alter"] = $mitglied->Alter;
				if ($mitglied->Firma == "1") { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = "ja"; } else { $arr["Strasse"][$i]["Mitglieder"][$j]["Firma"] = ""; }
				$arr["Strasse"][$i]["Mitglieder"][$j]["Status"] = $mitglied->Status;
				$j++;
				$mitglieder_gesamt++;
			}
		}
	}
}

$string = "<table class='plist'>";
$string .= "<thead>";
$string .= "<tr>";
	$string .= "<td class='lhead'>ID</td>";
	$string .= "<td class='lhead'>Name</td>";
	$string .= "<td class='lhead'></td>";
	$string .= "<td class='lhead'>Adresse</td>";
	$string .= "<td class='lhead'></td>";
	$string .= "<td class='lhead'></td>";
	$string .= "<td class='lhead'></td>";
	$string .= "<td class='lhead'></td>";
	$string .= "<td class='lhead'>Geb.</td>";
	$string .= "<td class='lhead'>Alter</td>";
	$string .= "<td class='lhead'>Firma</td>";
	$string .= "<td class='lhead'>gesammelt</td>";

$string .= "</tr>";
$string .= "</thead>";

$string .= "<tbody>";
for ($i=0;$i<count($arr["Strasse"]);$i++) {
	$string .= "<tr>";
	$string .= "<td class='jubtrenner' colspan='".(count($arr["Strasse"][2]["Mitglieder"][0])+1)."'>".$arr["Strasse"][$i]["Strassenname"]."</td>";
	$string .= "</tr>";	
	
	for ($j=0;$j<count($arr["Strasse"][$i]["Mitglieder"]);$j++) {
	if ($arr["Strasse"][$i]["Mitglieder"][$j]["Status"] != "Verstorben") {
		$string .= "<tr>";
			if ($arr["Strasse"][$i]["Mitglieder"][$j]) {
				if (($arr["Strasse"][$i]["Mitglieder"][$j]["Hausnummer"] == $arr["Strasse"][$i]["Mitglieder"][$j-1]["Hausnummer"]) && ($arr["Strasse"][$i]["Mitglieder"][$j]["Hausnummer"] != "")) {
					foreach ($arr["Strasse"][$i]["Mitglieder"][$j] as $key => $value) {
						if ($key != "Status") {
							$string .= "<td class=\"nobo\">";
							$string .= $value;
							$string .= "</td>";
						}
					}
					$string .= "<td class=\"nobo lebo\">";
					$string .= "";
					$string .= "</td>";		
				} else {
					foreach ($arr["Strasse"][$i]["Mitglieder"][$j] as $key => $value) {
						if ($key != "Status") {
							$string .= "<td class=\"tobo\">";
							$string .= $value;
							$string .= "</td>";
						}
					}
					$string .= "<td class=\"tobo lebo\">";
					$string .= "";
					$string .= "</td>";
				}
				$mitglieder_leben++;
				$string .= "</tr>";
			}
		}
	}
}

$string .= "</tbody>";

$string .= "</table>";
$string .= $mitglieder_leben." (".$mitglieder_gesamt.") Mitglieder gefunden!";

echo $string;

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