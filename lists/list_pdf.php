<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"list.pdf\"");
// Functions
function format_date($date) {
	$arr = preg_split("/-/", $date);
	$newdate = $arr[2].".".$arr[1].".".$arr[0];
	return $newdate;
}

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

$params["amt"] = 10;
$result = "";
$string = "";
$i=0;

$mitglieder=json_decode(send_request('mitglieder.php/','get',$params));

//$result["iTotalRecords"] = $mitglieder->count_all;
//$result["iTotalDisplayRecords"] = $mitglieder->count_query;

$string .= $mitglieder->query;

if ($mitglieder->mitglieder) {
	foreach ($mitglieder->mitglieder as $value) {
		$id = $value->id;
		$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));

		$geb = preg_split("/-/", $mitglied->Alter);
		$alter = alter($geb[2],$geb[1],$geb[0]);
		
		$result["aaData"][$i][0] = $mitglied->ID;
		$result["aaData"][$i][1] = $mitglied->Nachname;
		$result["aaData"][$i][2] = $mitglied->Vorname;
		$result["aaData"][$i][3] = $mitglied->Strasse;
		$result["aaData"][$i][4] = $mitglied->Hausnummer;
		$result["aaData"][$i][5] = $mitglied->PLZ;
		$result["aaData"][$i][6] = $mitglied->Ort;
		$result["aaData"][$i][7] = $mitglied->Ortsteil;
		$result["aaData"][$i][8] = format_date($mitglied->Geburtsdatum);
		$result["aaData"][$i][9] = $mitglied->Alter;
		$i++;
	}
}

if (isset($params["amt"])) {
	$end = $params["amt"];
} else {
	$end = $result["iTotalDisplayRecords"];
}

$param = json_encode($result);
$pdf=send_request2("http://192.168.242.110/djkclient/lists/get_pdf.php","post",$param);
print($pdf);
?>