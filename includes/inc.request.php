<?php

/********************************************************************************************************
	Rest Requests
	send to $restservicedir

*********************************/

require "RESTClient.php"; // Rest-Class
require_once "settings.php";   // Global Settings

function send_request($url,$method="get",$input=null) {
	global $restservicedir;
	$address = $restservicedir.$url;
	$client = new RESTClient();
	if ($method == "post") {
		$result = $client->post($address,$input);
	} elseif ($method == "get") {
		$result = $client->get($address,$input);
	} elseif ($method == "put") {
		$result = $client->put($address,$input);
	} else {
		$result = "Error: no method specified";
	}
	return $result;
}

function send_request2($url,$method="get",$input=null) {
	$client = new RESTClient();
	if ($method == "post") {
		$result = $client->post($url,$input);
	} elseif ($method == "get") {
		$result = $client->get($url,$input);
	} else {
		$result = "Error: no method specified";
	}
	return $result;
}
?>
