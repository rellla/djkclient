<?php
require "includes/inc.request.php";    // Request Routines
require "includes/inc.render.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings

function write_street_selectbox () {
	$i = 0;
	$street_selbox = "";
	$strassen = json_decode(send_request('/strassen.php/','get'));
	if ($strassen->strassen) {
		foreach ($strassen->strassen as $value) {
			$strasse = json_decode(send_request('/strassen.php/'.$value->id,'get'));
			$result[$i]["id"] = $strasse->Strasse->id;
			$result[$i]["name"] = $strasse->Strasse->Name;
			$i++;
		}
	}
	
	$street_selbox .= '<select name="Strasse">\n';
	for ($i=0;$i<count($result);$i++) {
		$street_selbox .= '<option value="'.$result[$i]["id"].'">';
		$street_selbox .= utf8_decode($result[$i]["name"]);
		$street_selbox .= '</option>';
	}
	$street_selbox .= '</select>\n';

	echo $street_selbox;
}
write_street_selectbox();


?>