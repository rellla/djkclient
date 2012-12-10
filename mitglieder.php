<?php

require "includes/inc.html.php";    // HTML Render Routines
require_once "includes/settings.php";   // Global Settings

build_header();


?>
<script>

var asInitVals = new Array();
var oTable;

$(document).ready(function(){

	oTable = $('table#datatable');

	write_table_head();
	oTable
		.dataTable({
			"aoColumns": [
				{ "sClass": "mid" },
				{ "sClass": "nname" },
				{ "sClass": "vname" },
				{ "sClass": "strname" },
				{ "sClass": "hausnummer" },
				{ "sClass": "plz" },
				{ "sClass": "ort" },
				{ "sClass": "ortsteil" },
				{ "sClass": "geburtsdatum" },
				{ "sClass": "edit" }
			],
			"aaSorting": [[ 1, "asc" ], [2, "asc"]],
			'bProcessing':true,
			'bServerSide':true,
			'sAjaxSource':'includes/ajax_get_mitglieder.php',
			'sPaginationType': 'full_numbers',
			"iDisplayLength": 15,
			"oLanguage": {
				"sProcessing":   "Bitte warten...",
				"sLengthMenu":   "_MENU_ Eintr&auml;ge anzeigen",
				"sZeroRecords":  "Keine Eintr&auml;ge vorhanden.",
				"sInfo":         "_START_ bis _END_ von _TOTAL_ Eintr&auml;gen",
				"sInfoEmpty":    "0 bis 0 von 0 Eintr&auml;gen",
				"sInfoFiltered": "(gefiltert von _MAX_  Eintr&auml;gen)",
				"sInfoPostFix":  "",
				"sSearch":       "Suchen",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "Erster",
					"sPrevious": "Zur&uuml;ck",
					"sNext":     "N&auml;chster",
					"sLast":     "Letzter"
				}
			},
			"fnDrawCallback": function() {
/*				$('table#datatable tbody td').editable('includes/table_update.php', {
					"callback": function( sValue, y ) {
						aPos = oTable.fnGetPosition( this );
						oTable.fnUpdate( sValue, aPos[0], aPos[1] );
					},
					"submitdata": function ( value, settings ) {
						var aPos = oTable.fnGetPosition( this );
						col = aPos[1];
						row = aPos[0];
						mid = parseInt($('table#datatable > tbody > tr:nth-child('+(row+1)+') > td:eq(0)').html());
						colname = $('table#datatable > thead > tr:eq(0) > th:nth-child('+(col+1)+')').html();
						return { "mid": mid,"col_id": colname };
					},
					"event": "dblclick",
					"tooltip": "Doppelklicken zum Editieren",
					"placeholder": "",
					"height": "24px",
					"width": "200px",
					"indicator" : 'Speichern...',
					"submit"    : 'OK',
					"cancel"    : 'Cancel'

				});
*/
				$i=0;
<?php
				include("includes/inc.jsonload.php");
?>
				$('table#datatable tbody tr').each(function() {
					$(this).attr("rel", $i);
					$i++;
				});
			}
		});

});

function write_table_head() {		
		rows = "<thead><tr>"; 			
		rows += "<th>ID</th>";
		rows += "<th>Nachname</th>";
 		rows += "<th>Vorname</th>"; 
		rows += "<th>Strasse</th>"; 
		rows += "<th>Hausnummer</th>"; 
		rows += "<th>PLZ</th>"; 
		rows += "<th>Ort</th>"; 
		rows += "<th>Ortsteil</th>"; 
		rows += "<th>Geburtsdatum</th>";
		rows += "<th>Edit</th>"; 
		rows += "</tr></thead>"; 	
		rows += "<tbody>";
		rows += "</tbody>";
		rows += "<tfoot>";
		rows += "</tfoot>";
		$('table#datatable').html("").html(rows);
}

</script>
<?php
build_body("Mitgliedertabelle");
print ('<div><a href="mitglied_neu.php" target="_blank">Neues Mitglied anlegen</a></div>');
?>

<div class="queryresult">
	<table id="datatable" class="mlist"></table>
</div>


<?php
build_footer();
?>