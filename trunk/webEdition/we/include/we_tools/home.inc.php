<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

	if(!(isset($GLOBALS["we_print_not_htmltop"]) && $GLOBALS["we_print_not_htmltop"])){
		htmlTop();
	}
	print STYLESHEET;
	
	
	$we_head_insert = isset($GLOBALS["we_head_insert"]) ? $GLOBALS["we_head_insert"] : "";
	$we_body_insert = isset($GLOBALS["we_body_insert"]) ? $GLOBALS["we_body_insert"] : "";
	
	
	$_row = 0;
	$_starttable = new we_htmlTable(	array(	"border"      => "0",
												"cellpadding" => "7",
												"cellspacing" =>"0",
												"width" => "228"),
										3,
										1);
	$_starttable->setCol($_row++,0, array(	"class"   => "defaultfont",
											"colspan" => 3,
											"align"=>"center"), "<strong>" .
											$title . "</strong>");

	$_starttable->setCol($_row++,0, array(	"class"   => "defaultfont",
											"colspan" => 3), "");


	$_starttable->setCol($_row++, 0, array("align"=>"center"), $content);
?>
	<style media="screen" type="text/css">
	<?php
	$_x_table = 50;
	$_y_table = 0;

	$_x_table_back = $_x_table -10;
	$_y_table_back = $_y_table + 3;

	$_x_we3 = $_x_table_back + 120;
	$_y_we3 = $_y_table_back + 116;
	?>
		#tabelle     { position: absolute; top: 0px; left: 50px; width: 100px; height: 100px; visibility: visible; z-index: 3 }
		#hintergrund { position: absolute; top: 3px; left: 40px; width: 251px; height: 220px; visibility: visible; z-index: 2 }
		#modimage    { position: absolute; top: 131px; left: 286px; width: 335px; height: 329px; visibility: visible; z-index: 1 }

	</style>

	<?php print $we_head_insert; ?>

</head>

<?php 
if($tool=='weSearch' || $tool=='navigation') {
	 $tooldir = '/webEdition/we/include/we_tools/';
}
else {
	$tooldir = WE_TOOLS_PATH;
}

?>

<body bgcolor="#F0EFF0" onload="loaded=1;">
	<div id="tabelle"><?php print $_starttable->getHtmlCode(); ?></div>
	<div id="hintergrund"><img src="<?php print IMAGE_DIR . "startscreen/we_startbox_modul.gif" ?>" width="251" height="220"></div>
	<div id="modimage"><img src="<?php print $tooldir . $tool . '/' . 'layout/home.gif'; ?>" width="335" height="329"></div>

	<?php print $we_body_insert; ?>
	<script type="text/javascript">
		var we_is_home = 1;
	</script>

</body>

</html>