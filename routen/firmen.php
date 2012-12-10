<?php
$params["search_sql"] = " WHERE firma=1";
$params["sdir"] = "asc";
$params["scol_name"] = "nname";
require_once "../includes/inc.request.php";    // Request Routines
require_once "../includes/inc.render.php";    // HTML Render Routines
include "inc.list.php";    // Request Routines
?>