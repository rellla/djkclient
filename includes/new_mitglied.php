<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings

if (isset($_GET['id'])) { $id = $_GET['id']; } else { $id=1; };
$result = "";

$mitglieder = json_decode(send_request('/mitglieder.php/','get'));
$result["gesamt"] = $mitglieder->count_all;

$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));
$result["id"] = $mitglied->ID;
$result["Nachname"] = $mitglied->Nachname;
$result["Vorname"] = $mitglied->Vorname;
$result["Strasse"] = $mitglied->Strasse;
$result["Hausnummer"] = $mitglied->Hausnummer;
$result["PLZ"] = $mitglied->PLZ;
$result["Ort"] = $mitglied->Ort;
$result["Ortsteil"] = $mitglied->Ortsteil;
$result["Geburtsdatum"] = format_date($mitglied->Geburtsdatum);
$result["Geschlecht"] = $mitglied->Geschlecht;
$result["Alter"] = $mitglied->Alter;
$result["Status"] = $mitglied->Status;
$result["Eintritt"] = $mitglied->Eintritt;
$result["Austritt"] = $mitglied->Austritt;
$result["BeitragHV"] = $mitglied->BeitragHV;
$result["BeitragHVbez"] = $mitglied->BeitragHVbez;
$result["BeitragST"] = $mitglied->BeitragST;
$result["BeitragSTbez"] = $mitglied->BeitragSTbez;
$result["BeitragT"] = $mitglied->BeitragT;
$result["BeitragTbez"] = $mitglied->BeitragTbez;
if ($mitglied->Fussball == 1) { $result["Fussball"] = "x"; } else { $result["Fussball"] = ""; };
if ($mitglied->Tennis == 1) { $result["Tennis"] = "x"; } else { $result["Tennis"] = ""; };
if ($mitglied->Stock == 1) { $result["Stock"] = "x"; } else { $result["Stock"] = ""; };
if ($mitglied->Gymnastik == 1) { $result["Gymnastik"] = "x"; } else { $result["Gymnastik"] = ""; };


$mitglied_prev = json_decode(send_request('/mitglieder.php/'.($id-1),'get'));
$result_prev["id"] = $mitglied_prev->ID;
$result_prev["Nachname"] = $mitglied_prev->Nachname;
$result_prev["Vorname"] = $mitglied_prev->Vorname;

$mitglied_next = json_decode(send_request('/mitglieder.php/'.($id+1),'get'));
$result_next["id"] = $mitglied_next->ID;
$result_next["Nachname"] = $mitglied_next->Nachname;
$result_next["Vorname"] = $mitglied_next->Vorname;


function write_street_selectbox ($sel_strasse) {
	$i = 0;
	$selbox = "";
	$strassen = json_decode(send_request('/strassen.php/','get'));
	if ($strassen->strassen) {
		foreach ($strassen->strassen as $value) {
			$strasse = json_decode(send_request('/strassen.php/'.$value->id,'get'));
			$result[$i]["id"] = $strasse->Strasse->id;
			$result[$i]["name"] = $strasse->Strasse->Name;
			$i++;
		}
	}
	
	$selbox .= '<select name="Strasse">';
	for ($i=0;$i<count($result);$i++) {
		if ($sel_strasse == $result[$i]["name"]) {
			$selbox .= '<option selected value="'.$result[$i]["id"].'">';
		} else {
			$selbox .= '<option value="'.$result[$i]["id"].'">';
		}
		$selbox .= $result[$i]["name"];
		$selbox .= '</option>';
	}
	$selbox .= '</select>';

	echo $selbox;
}

function write_orte_selectbox ($sel_ort) {
	$i = 0;
	$selbox = "";
	$orte = json_decode(send_request('/orte.php/','get'));
	if ($orte->orte) {
		foreach ($orte->orte as $value) {
			$ort = json_decode(send_request('/orte.php/'.$value->id,'get'));
			$result[$i]["id"] = $ort->Ort->id;
			$result[$i]["plz"] = $ort->Ort->PLZ;
			$result[$i]["ortsname"] = $ort->Ort->Ortsname;
			$result[$i]["ortsteil"] = $ort->Ort->Ortsteil;
			$i++;
		}
	}
	
	$selbox .= '<select name="Ort">';
	for ($i=0;$i<count($result);$i++) {
		if ($sel_ort == ($result[$i]["plz"].', '.$result[$i]["ortsname"].'/ '.$result[$i]["ortsteil"])) {
			$selbox .= '<option selected value="'.$result[$i]["id"].'">';
		} else {
			$selbox .= '<option value="'.$result[$i]["id"].'">';
		}
		$selbox .= $result[$i]["plz"].', '.$result[$i]["ortsname"].'/ '.$result[$i]["ortsteil"];
		$selbox .= '</option>';
	}
	$selbox .= '</select>';

	echo $selbox;
}

function write_status_selectbox ($sel_status) {
	$i = 0;
	$selbox = "";
	$stati = json_decode(send_request('/status.php/','get'));
	if ($stati->stati) {
		foreach ($stati->stati as $value) {
			$status = json_decode(send_request('/status.php/'.$value->id,'get'));
			$result[$i]["id"] = $status->Status->id;
			$result[$i]["Status"] = $status->Status->Status;
			$i++;
		}
	}
	
	$selbox .= '<select name="Status">';
	for ($i=0;$i<count($result);$i++) {
		if ($sel_status == $result[$i]["Status"]) {
			$selbox .= '<option selected value="'.$result[$i]["id"].'">';
		} else {
			$selbox .= '<option value="'.$result[$i]["id"].'">';
		}
		$selbox .= $result[$i]["Status"];
		$selbox .= '</option>';
	}
	$selbox .= '</select>';

	echo $selbox;
}

function write_geschlecht_selectbox ($sel_geschlecht) {
	$i = 0;
	$selbox = "";
	$selbox .= '<select name="Geschlecht">';
		if ($sel_geschlecht == "w") {
			$selbox .= '<option selected value="w">Weiblich</option>';
			$selbox .= '<option value="m">M&auml;nnlich</option>';
		} else {
			$selbox .= '<option value="w">Weiblich</option>';
			$selbox .= '<option selected value="m">M&auml;nnlich</option>';
		}
	$selbox .= '</select>';

	echo $selbox;
}

function write_abteilungs_select ($sel,$sel_name) {
	$i = 0;
	$selbox = "";
	$selbox .= '<input value="1" type="checkbox" name="'.$sel_name.'"';
		if ($sel == "x") {
			$selbox .= ' checked';
		} else {
			$selbox .= '';
		}

	echo $selbox;
}


?>
<script>
$(document).ready(function(){
	$('#prev').bind('click',
		function() {
			$('#mitglied').load('includes/edit_mitglied.php?id=<?php print($_GET['id']-1); ?>');
		}
	);

	$('#next').bind('click',
		function() {
			$('#mitglied').load('includes/edit_mitglied.php?id=<?php print($_GET['id']+1); ?>');
		}
	);
	<?php if ($result["id"]<2) { print("$('#prev').hide();"); } else { print("$('#prev').show();"); } ?>
	<?php if ($result["id"]>($result["gesamt"]-1)) { print("$('#next').hide();"); } else { print("$('#next').show();"); } ?>
	
	function showValues() {
		var str = JSON.stringify($("form").serializeObject());
		$("#results").text(str);
	}
	$(":checkbox, :radio").click(showValues);
	$("select, input").change(showValues);
	showValues();
	
	$("form").submit(function() {
		$.post("includes/update_mitglied.php",
				JSON.stringify($(this).serializeObject()),
				function(data){
					alert(data);
				}
		);
		return false;
	});

});
</script>


<h4>Mitglied Nr.: <?php print($result["id"]); ?></h4>
<form>
<input name="ID" type="hidden" value="<?php print($result["id"]); ?>">
<div class="m_left">
<table>

<tr>
	<td width="100px">Adresse:</td>
	<td width="250px">
		<input name="Nachname" type="text" value="<?php print($result["Nachname"]); ?>">
		&nbsp;
		<input name="Vorname" type="text" value="<?php print($result["Vorname"]); ?>"></td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><?php write_street_selectbox($result["Strasse"]); ?>
	&nbsp;
	<input class="small" name="Hausnummer" type="text" value="<?php print($result["Hausnummer"]); ?>"></td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><?php write_orte_selectbox($result["PLZ"].', '.$result["Ort"].'/ '.$result["Ortsteil"]); ?></td>
</tr>

<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td>Geburtsdatum:</td>
<td>
	<input name="Geburtsdatum" type="text" value="<?php print($result["Geburtsdatum"]); ?>">
	&nbsp;
	<?php print("(".$result["Alter"].")"); ?>
</td>
</tr>
<tr>
<td>Geschlecht:</td><td><?php write_geschlecht_selectbox($result["Geschlecht"]);?></td>
</tr>
</table>
</div>

<div class="m_right">
<table>
<tr>
<td width="150px">Status:</td><td><?php write_status_selectbox($result["Status"]); ?></td>
</tr>
<tr>
<td>Eintritt:</td>
<td>
	<input name="Eintritt" type="text" value="<?php print($result["Eintritt"]); ?>">
</td>
</tr>
<tr>
<td>Austritt:</td>
<td>
	<input name="Austritt" type="text" value="<?php print($result["Austritt"]); ?>">
</td>
</tr>
<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td>Fu&szlig;ball:</td><td><?php write_abteilungs_select($result["Fussball"],"Fussball");?></td>
</tr>
<tr>
<td>Tennis:</td><td><?php write_abteilungs_select($result["Tennis"],"Tennis");?></td>
</tr>
<tr>
<td>Stock:</td><td><?php write_abteilungs_select($result["Stock"],"Stock");?></td>
</tr>
<tr>
<td>Gymnastik:</td><td><?php write_abteilungs_select($result["Gymnastik"],"Gymnastik");?></td>
</tr>
<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td>Beitrag Hauptverein:</td><td><?php print(number_format($result["BeitragHV"],2,',','.')." &euro; (".$result["BeitragHVbez"].")"); ?></td>
</tr>
<tr>
<td>Beitrag Stock:</td><td><?php print(number_format($result["BeitragST"],2,',','.')." &euro; (".$result["BeitragSTbez"].")"); ?></td>
</tr>
<tr>
<td>Beitrag Tennis:</td><td><?php print(number_format($result["BeitragT"],2,',','.')." &euro; (".$result["BeitragTbez"].")"); ?></td>
</tr>
<tr>
<td>Beitrag gesamt:</td><td><?php print(number_format(($result["BeitragHV"]+$result["BeitragST"]+$result["BeitragT"]),2,',','.')." &euro;"); ?></td>
</tr>
</table>
</div>
<input type="submit" value=" Speichern ">
</form>
<br style='clear:both;'>
<div id="results"></div>
<div class="m_navigation">
<div id="prev">&lt;&nbsp;<?php print($result_prev["Nachname"]."&nbsp;".$result_prev["Vorname"]); ?></div>
<div id="next"><?php print($result_next["Nachname"]."&nbsp;".$result_next["Vorname"]); ?>&nbsp;&gt;</div>
</div>
