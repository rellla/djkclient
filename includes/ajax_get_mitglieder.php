<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings

function nrtoname($nr,$array) {
	$res = $array[(int)$nr];
	return $res;
}


$cols=array('mid','nname','vname','strname','hausnr','plz','ortname','ortsteil','geburtstag');

$params["start"] = 0;
$params["amt"] = 10;
$params["scol"] = 0;
$params["sdir"] = "asc";
$params["search_sql"] = "";
// Andreas neu
$params["sort"] = "vname asc, ";

if(isset($_REQUEST['iDisplayLength'])) { 
	$params["amt"]=(int)$_REQUEST['iDisplayLength'];
	if ($params["amt"]>100 || $params["amt"]<10) $params["amt"]=10;
}

if(isset($_REQUEST['iDisplayStart'])) { 
	$params["start"]=(int)$_REQUEST['iDisplayStart'];
	if ($params["start"]<0) $params["start"]=0;
}


// Andreas neu
if(isset($_REQUEST['iSortCol_0'])) { 
	for ( $i=0 ; $i<$_REQUEST['iSortingCols']; $i++ ) {
		$params["scol"]=(int)$_REQUEST['iSortCol_'.$i];
		if ($params["scol"]>(count($cols)-1) || $params["scol"]<0 ) $params["scol"]=0;
		$params["sort"]=nrtoname((int)$params["scol"])." ".$_REQUEST['sSortDir_'.$i].", ";
	}
	$sOrder = substr_replace( $params["sort"], "", -2 );
}

/*
if(isset($_REQUEST['iSortCol_0'])) { 
		$params["scol"]=(int)$_REQUEST['iSortCol_0'];
		if ($params["scol"]>(count($cols)-1) || $params["scol"]<0 ) $params["scol"]=0;
}
*/
if(isset($_REQUEST['sSortDir_0'])) {
	if ($_REQUEST['sSortDir_0'] != "asc") { $params["sdir"]="desc"; };
}

if(isset($_REQUEST['sSearch']) && '' != $_REQUEST['sSearch']) {
	$stext = addslashes($_REQUEST['sSearch']);
	$params["search_sql"] = ' WHERE ';
	$params["search_sql"] .= "vname like '$stext%' or nname like '$stext%' or strname like '$stext%' or ortname like '$stext%'";
}

// Andreas neu
// $params["scol_name"] = $cols[(int)$params["scol"]];


$result = "";
$i=0;

$mitglieder=json_decode(send_request('mitglieder.php/','get',$params));

$result["iTotalRecords"] = $mitglieder->count_all;
$result["iTotalDisplayRecords"] = $mitglieder->count_query;
//$result["count_listed"] = $mitglieder->count_listed;

foreach ($mitglieder->mitglieder as $value) {
	$id = $value->id;
	$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));
	$result["aaData"][$i][0] = $mitglied->ID;
	$result["aaData"][$i][1] = $mitglied->Nachname;
	$result["aaData"][$i][2] = $mitglied->Vorname;
	$result["aaData"][$i][3] = $mitglied->Strasse;
	$result["aaData"][$i][4] = $mitglied->Hausnummer;
	$result["aaData"][$i][5] = $mitglied->PLZ;
	$result["aaData"][$i][6] = $mitglied->Ort;
	$result["aaData"][$i][7] = $mitglied->Ortsteil;
	$result["aaData"][$i][8] = format_date($mitglied->Geburtsdatum);
	$result["aaData"][$i][9] = "<a href='mitglied.php?id=".$mitglied->ID."'>Edit</a>";
	$i++;
}

set_headers();
render_result($result);
?>