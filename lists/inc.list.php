<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings

// $params["amt"] = 10;
$result = "";
$string = "";
$i=0;
$mitglieder_gesamt = 0;
$mitglieder_leben = 0;
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
		
		$result["aaData"][$i]["ID"] = $mitglied->ID;
		$result["aaData"][$i]["Nachname"] = $mitglied->Nachname;
		$result["aaData"][$i]["Vorname"] = $mitglied->Vorname;
		$result["aaData"][$i]["Strasse"] = $mitglied->Strasse;
		$result["aaData"][$i]["Hausnummer"] = $mitglied->Hausnummer;
		$result["aaData"][$i]["PLZ"] = $mitglied->PLZ;
		$result["aaData"][$i]["Ort"] = $mitglied->Ort;
		$result["aaData"][$i]["Ortsteil"] = $mitglied->Ortsteil;
		$result["aaData"][$i]["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
		$result["aaData"][$i]["Alter"] = $mitglied->Alter;
		$result["aaData"][$i]["Status"] = $mitglied->Status;
		$mitglieder_gesamt++;
		$i++;
	}
}

if (isset($params["amt"])) {
	$end = $params["amt"];
} else {
	$end = $result["iTotalDisplayRecords"];
}

$param = json_encode($result);
// build html
?>
<script>
$(document).ready(function(){
	$("#csv").live('click',
		function() {
			$.download('includes/make_csv.php','content=' + '<?php print($param); ?>' );
		}
	);
	$("#pdf").live('click',
		function() {
			$.download('lists/list_pdf.php','content=' + '<?php print($param); ?>' );
		}
	);
});

</script>
<div id="csv">Download CSV</div>

<?php
// <div id="pdf">Download PDF</div>
// $string .= "<a href='lists/list_pdf.php'>Download PDF</a>";
$string .= "<table class='plist'>";

$string .= "<thead>";
$string .= "<tr>";
foreach ($result["aaData"][0] as $key => $value) {
	if ($key != "Status") {
		$string .= "<td class='lhead'>";
		$string .= $key;
		$string .= "</td>";
	}
}
$string .= "</tr>";
$string .= "</thead>";

$string .= "<tbody>";
for ($i=0;$i<$end;$i++) {
	if ($result["aaData"][$i]["Status"] != "Verstorben") {
		$string .= "<tr>";
		foreach ($result["aaData"][$i] as $key => $value) {
			if ($key != "Status") {
				$string .= "<td>";
				$string .= $value;
				$string .= "</td>";
			}	
		}
		$string .= "</tr>";
		$mitglieder_leben++;
	}
}
$string .= "</tbody>";

$string .= "</table>";
$string .= $mitglieder_leben." (".$mitglieder_gesamt.") Mitglieder gefunden!";
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

?>