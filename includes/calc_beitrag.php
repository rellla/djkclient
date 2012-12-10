<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // POST Request
	$input = file_get_contents("php://input");
	$res = json_decode($input);
	$beitraegehv = json_decode(send_request('/beitraege.php/hv/'.$res->BeitragHV,'get'));
	$beitraeget = json_decode(send_request('/beitraege.php/t/'.$res->BeitragT,'get'));
	$beitraegest = json_decode(send_request('/beitraege.php/st/'.$res->BeitragST,'get'));

	$beitrag = $beitraegehv->Beitrag[0]->Betrag + $beitraegest->Beitrag[0]->Betrag + $beitraeget->Beitrag[0]->Betrag;
	
	print(number_format(($beitrag),2,',','.')." &euro;");
}


?>