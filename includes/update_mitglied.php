<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // POST Request
	$input = file_get_contents("php://input");
	//$res = json_decode(send_request('/mitglieder.php/','post'));
	$res = send_request('/mitglieder.php/','put',$input);
	//echo $input;

}
	echo $res;

?>