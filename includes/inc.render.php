<?php

/*******************/
/* Render routines */
/*******************/

function set_headers($type="json") {
	switch ($type) {
		// XML
		case "xml":
			header("Content-Type: text/xml; charset=utf-8");
			break;
		//JSON
		case "json":
			header("Content-Type: application/json; charset=utf-8");
			break;
		//JSON
		case "json_read":
			header("Content-Type: text/plain");
			break;
		//HTML
		case "html":
			header("Content-Type: text/html");		
			break;
		//HTML-table
		case "html_table":
			header("Content-Type: text/html");		
			break;
		//RAW
		case "raw":
			break;
	}
}

function render_result($array, $wrapper="array", $type="json") {
	switch ($type) {
		// XML
		case "xml":
			echo array2xml($array,$wrapper);
			break;
		//JSON
		case "json":
			echo json_encode($array); // php internal function, input is array
			break;
		//JSON - human-readable ( only for debug)
		case "json_read":
			echo make_readable(json_encode($array)); // php internal function, input is array
			break;
		//HTML
		case "html":
			html_show_array($array);
			break;
		//HTML Table
		case "html_table":
			html_table_show_array($array);
			break;
		//RAW
		case "raw":
			print_r($array); // php internal function, input is array (only for debug)
			break;
	}
}

/**************************************
/ Render XML
/ Input is an array
/ *************************************/

function array2xml($array, $tag="array", $subst="nr") {
	return "<$tag>".ia2xml($array,$subst)."</$tag>";
}

function ia2xml($array,$subst) {
	$xml="";
	foreach ($array as $key=>$value) {
		if (is_array($value)) {
			if (is_numeric($key)) {
				$xml.="<".$subst."_".$key.">".(ia2xml($value,$subst))."</".$subst."_".$key.">";
			} else {
				$xml.="<$key>".ia2xml($value,$subst)."</$key>";
			}
		} else {
			/*$value = preg_replace("/&(?!amp;)/","&amp;",$value);
			$value = str_replace("<","&lt;",$value);
			$value = str_replace(">","&gt;",$value);
			$value = str_replace("\"","&quot;",$value);
			$value = str_replace("'","&apos;",$value);
			$value = str_replace("%","&#37;",$value);*/
			$value = htmlspecialchars($value);
			if (is_numeric($key)) {
				$xml.="<".$subst."_".$key.">".$value."</".$subst."_".$key.">" ;
			} else {
				$xml.="<$key>".$value."</$key>" ;
			}
		}
	}
	return $xml;
}

/**************************************
/ Make JSON-String readable
/ Input is a json string
/ *************************************/

function make_readable($json) {
    $result    = '';
    $pos       = 0;
    $strLen    = strlen($json);
    $indentStr = '  ';
    $newLine   = "\n";
    for($i = 0; $i <= $strLen; $i++) {
        // Grab the next character in the string
        $char = substr($json, $i, 1);
        // If this character is the end of an element, 
        // output a new line and indent the next line
        if($char == '}' || $char == ']') {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        // Add the character to the result string
        $result .= $char;
        // If the last character was the beginning of an element, 
        // output a new line and indent the next line
        if ($char == ',' || $char == '{' || $char == '[') {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
    }
    return $result;
}


/**************************************
/* Render HTML
   Input is an array

*/

function do_offset($level){
    $offset = "";             // offset for subarry 
    for ($i=1; $i<$level;$i++){
    $offset = $offset . "<td></td>";
    }
    return $offset;
}

function show_array($array, $level, $sub){
    if (is_array($array) == 1){          // check if input is an array
       foreach($array as $key_val => $value) {
           $offset = "";
           if (is_array($value) == 1){   // array is multidimensional
           echo "<tr>";
           $offset = do_offset($level);
           echo $offset . "<td>" . $key_val . "</td>";
           show_array($value, $level+1, 1);
           }
           else{                        // (sub)array is not multidim
           if ($sub != 1){          // first entry for subarray
               echo "<tr nosub>";
               $offset = do_offset($level);
           }
           $sub = 0;
           echo $offset . "<td main ".$sub." width=\"120\">" . $key_val . 
               "</td><td width=\"120\">" . $value . "</td>"; 
           echo "</tr>\n";
           }
       } // foreach $array
    }  
    else { // argument $array is not an array
        return;
    }
}

function html_show_array($array){
  echo "<html>";
  echo "<body>";
  echo "<table cellspacing=\"0\" border=\"2\">\n";
  show_array($array, 1, 0);
  echo "</table>\n";
  echo "</html>";
  echo "</body>";
}

function html_table_show_array($array){
  echo "<table cellspacing=\"0\" border=\"2\">\n";
  show_array($array, 1, 0);
  echo "</table>\n";
}

function format_date($date) {
	$arr = preg_split("/-/", $date);
	$newdate = $arr[2].".".$arr[1].".".$arr[0];
	return $newdate;
}
?>