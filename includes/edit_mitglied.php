<?php
require "inc.request.php";    // Request Routines
require "inc.render.php";    // HTML Render Routines
require_once "settings.php";   // Global Settings

if (isset($_GET['id'])) { $id = $_GET['id']; } else { $id="new"; };
$result = "";

$mitglieder = json_decode(send_request('/mitglieder.php/','get'));
$result["gesamt"] = $mitglieder->count_all;
$new_id = $mitglieder->count_max_id+1;


$mitglied = json_decode(send_request('/mitglieder.php/'.$id,'get'));
$result["id"] = ($id != "new") ? $mitglied->ID : $new_id;
$result["Nachname"] = ($id != "new") ? $mitglied->Nachname : "Nachname";
$result["Vorname"] = ($id != "new") ? $mitglied->Vorname : "Vorname";
$result["Strasse"] = ($id != "new") ? $mitglied->Strasse : "";
$result["Hausnummer"] = ($id != "new") ? $mitglied->Hausnummer : "";
$result["PLZ"] = ($id != "new") ? $mitglied->PLZ : "";
$result["Ort"] = ($id != "new") ? $mitglied->Ort : "";
$result["Ortsteil"] = ($id != "new") ? $mitglied->Ortsteil : "";
$result["Geburtsdatum"] = ($id != "new") ? format_date($mitglied->Geburtsdatum) : "";
$result["Geschlecht"] = ($id != "new") ? $mitglied->Geschlecht : "";
$result["Status"] = ($id != "new") ? $mitglied->Status : "Aktiv";
$result["Eintritt"] = ($id != "new") ? $mitglied->Eintritt : "";
$result["Austritt"] = ($id != "new") ? $mitglied->Austritt : "";
$result["BeitragHV"] = ($id != "new") ? $mitglied->BeitragHV : "";
$result["BeitragHVbez"] = ($id != "new") ? $mitglied->BeitragHVbez: "Erwachsener";
$result["BeitragST"] = ($id != "new") ? $mitglied->BeitragST : "";
$result["BeitragSTbez"] = ($id != "new") ? $mitglied->BeitragSTbez : "Beitragsfrei";
$result["BeitragT"] = ($id != "new") ? $mitglied->BeitragT : "";
$result["BeitragTbez"] = ($id != "new") ? $mitglied->BeitragTbez : "Beitragsfrei";
$result["Fussball"] = ($id != "new") ? ( ($mitglied->Fussball == 1) ? "x" : "" ) : "x";
$result["Tennis"] = ($id != "new") ? ( ($mitglied->Tennis == 1) ? "x" : "" ) : "";
$result["Stock"] = ($id != "new") ? ( ($mitglied->Stock == 1) ? "x" : "" ) : "";
$result["Gymnastik"] = ($id != "new") ? ( ($mitglied->Gymnastik == 1) ? "x" : "" ) : "";
$result["Firma"] = ($id != "new") ? ( ($mitglied->Firma == 1) ? "x" : "" ) : "";

if ($id != "new") {
	$mitglied_prev = json_decode(send_request('/mitglieder.php/'.($id-1),'get'));
	$result_prev["id"] = $mitglied_prev->ID;
	$result_prev["Nachname"] = $mitglied_prev->Nachname;
	$result_prev["Vorname"] = $mitglied_prev->Vorname;

	$mitglied_next = json_decode(send_request('/mitglieder.php/'.($id+1),'get'));
	$result_next["id"] = $mitglied_next->ID;
	$result_next["Nachname"] = $mitglied_next->Nachname;
	$result_next["Vorname"] = $mitglied_next->Vorname;
}

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
			$selbox .= '<option value="m">M&auml;nnlich</option>';
			$selbox .= '<option selected value="w">Weiblich</option>';
		} else {
			$selbox .= '<option selected value="m">M&auml;nnlich</option>';
			$selbox .= '<option value="w">Weiblich</option>';

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

function write_beitrag_selectbox ($sel_status,$abt) {
	$i = 0;
	$selbox = "";
	
	switch ($abt) {
		case "hv":
			$beitraege = json_decode(send_request('/beitraege.php/hv','get'));
			break;
		case "t":
			$beitraege = json_decode(send_request('/beitraege.php/t','get'));
			break;
		case "st":
			$beitraege = json_decode(send_request('/beitraege.php/st','get'));
			break;
	}
	if ($beitraege->Beitrag) {
		foreach ($beitraege->Beitrag as $value) {
			$result[$i]["id"] = $value->id;
			$result[$i]["Betrag"] = $value->Betrag;
			$result[$i]["Bezeichnung"] = $value->Bezeichnung;
			$i++;
		}
	}
	switch ($abt) {
		case "hv":
			$selbox .= '<select name="BeitragHV">';
			break;
		case "t":
			$selbox .= '<select name="BeitragT">';
			break;
		case "st":
			$selbox .= '<select name="BeitragST">';
			break;
	}	
	for ($i=0;$i<count($result);$i++) {
		if ($sel_status == $result[$i]["Bezeichnung"]) {
			$selbox .= '<option selected value="'.$result[$i]["id"].'">';
		} else {
			$selbox .= '<option value="'.$result[$i]["id"].'">';
		}
		$selbox .= $result[$i]["Bezeichnung"];
		$selbox .= " (";
		$selbox .= $result[$i]["Betrag"];
		$selbox .= "&euro;)";
		
		$selbox .= '</option>';
	}
	$selbox .= '</select>';

	echo $selbox;
}

?>
<script>
$(document).ready(function(){
	<?php if ($result["id"]!="new") {
		print ("$('#prev').bind('click',
			function() {
				$('#mitglied').load('includes/edit_mitglied.php?id=".($_GET['id']-1)."');
			}
		);

		$('#next').bind('click',
			function() {
				$('#mitglied').load('includes/edit_mitglied.php?id=".($_GET['id']+1)."');
			}
		);");
		if ($result["id"]<2) { print("$('#prev').hide();"); } else { print("$('#prev').show();"); }
		if ($result["id"]>($result["gesamt"]-1)) { print("$('#next').hide();"); } else { print("$('#next').show();"); }
	}?>
	
	function showValues() {
		var str = JSON.stringify($("form").serializeObject());
		$("#results").text(str);
	}
	
	function updateBeitrag() {
		$.post("includes/calc_beitrag.php",	
				JSON.stringify($("form").serializeObject()),
				function(data){
					$("#beitrag").html(data);
				}
		);	
	}
	
	function alter_berechnen(gebdate) {
		arr = gebdate.split(".");
		G_tag = parseInt(arr[0]);	
		G_monat = parseInt(arr[1]);
		G_jahr = parseInt(arr[2]);
		alter = 0;
		if ((G_jahr > 0) && (G_monat > 0) && (G_tag > 0)) { 
			H_datum = new Date();
							
			H_tag = H_datum.getDate();
			H_monat = H_datum.getMonth()+1;
			H_jahr = H_datum.getYear()+1900;

			alter = H_jahr - G_jahr;

			if ( G_monat > H_monat ) {
				alter = alter - 1;
			} else if (G_monat == H_monat) {
				if (G_tag > H_tag)	{
					alter = alter - 1;
				}
			}
			return(alter); 
		} else {
			return("-");
		}
		
	}
		
	function updateAlter() {
		gebdate = $("#gebdate").val();
		alter = "("+alter_berechnen(gebdate)+")";
		$("#alter").html(alter);
	}
	
	$(":checkbox, :radio").click(showValues);
	$("select, input").change(showValues);
	$(".beitrag").change(updateBeitrag);
	$("#gebdate").change(updateAlter);
	
	showValues();
	updateBeitrag();
	updateAlter();
	
	$("form").submit(function() {
		$.post("includes/update_mitglied.php",
				JSON.stringify($(this).serializeObject()),
				function(data){
					var mess = eval('(' + data + ')');
					messag = mess.message;
					messag += "<br><a href='mitglied_neu.php' target='_self'>weiteres neues Mitglied erfassen</a>";
					$("#message").html(messag);
				}
		);
		return false;
	});

});
</script>

<div id="message"></div>
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
	<input id="gebdate" name="Geburtsdatum" type="text" value="<?php print($result["Geburtsdatum"]); ?>">&nbsp;<span id="alter"></span>
</td>
</tr>
<tr>
<td>Geschlecht:</td><td><?php write_geschlecht_selectbox($result["Geschlecht"]);?></td>
</tr>
<tr>
<td>Firma?:</td><td><?php write_abteilungs_select($result["Firma"],"Firma");?></td>
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
<td>Beitrag Hauptverein:</td><td id="beitraghv" class="beitrag"><?php write_beitrag_selectbox($result["BeitragHVbez"],"hv");?></td>
</tr>
<tr>
<td>Beitrag Stock:</td><td id="beitragst" class="beitrag"><?php write_beitrag_selectbox($result["BeitragSTbez"],"st");?></td>
</tr>
<tr>
<td>Beitrag Tennis:</td><td id="beitragt" class="beitrag"><?php write_beitrag_selectbox($result["BeitragTbez"],"t");?></td>
</tr>
<tr>
<td>Beitrag gesamt:</td><td id="beitrag"></td>
</tr>
</table>
</div>
<?php if ($id == "new") { print ('<input type="hidden" name="neu" value="1">'); } else { print ('<input type="hidden" name="neu" value="0">'); } ?>
<input type="submit" value=" Speichern ">
</form>
<br style='clear:both;'>
<div id="results"></div>
<div class="m_navigation">
<?php if ($id != "new") {
	print('<div id="prev">&lt;&nbsp;'.$result_prev["Nachname"].'&nbsp;'.$result_prev["Vorname"].'</div>');
	print('<div id="next">'.$result_next["Nachname"].'&nbsp;'.$result_next["Vorname"].'&nbsp;&gt;</div>');
	}?>
</div>