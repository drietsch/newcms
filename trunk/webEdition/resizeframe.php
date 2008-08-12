<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

protect();
htmlTop();


//	Here begins the code for showing the correct frameset.
//	To improve readability the different cases are outsourced
//	in several functions, for SEEM, normal or edit_include-Mode.

/**
 * function startNormalMode()
 * @desc	This function writes the frameset in the resizeframe for the webedition-start
 			in the normal mode.
 */

function startNormalMode() {
	
	$_treewidth = isset($_COOKIE["treewidth_main"]) ? $_COOKIE["treewidth_main"]  : WE_TREE_DEFAULT_WIDTH;

	// Get the width of the sidebar
	$_sidebarwidth = 0;
	if(defined("SIDEBAR_DISABLED") && SIDEBAR_DISABLED == 1) {
		$_sidebarwidth = 0;
		
	} else if(!defined("SIDEBAR_SHOW_ON_STARTUP") || SIDEBAR_SHOW_ON_STARTUP == 1) {
		if(defined("SIDEBAR_DEFAULT_WIDTH")) {
			$_sidebarwidth = SIDEBAR_DEFAULT_WIDTH;
			
		} else {
			$_sidebarwidth = 300;
			
		}
		
	}
	if ($GLOBALS["BROWSER"] == "NN6"){
?>
	<frameset cols="<?php print $_treewidth; ?>,*,<?php print $_sidebarwidth; ?>" border="1" id="resizeframeid">
		<frame src="baumFrame.php" name="bframe" scrolling="no">
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php" name="bm_content_frame">
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="<?php print $_treewidth; ?>,*,<?php print $_sidebarwidth; ?>" border="0" frameborder="0" id="resizeframeid">
		<frame src="baumFrame.php" name="bframe" scrolling="no">
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php" name="bm_content_frame">
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</frameset>
<?php } else { //IE ?>
	<frameset cols="<?php print $_treewidth; ?>,*,<?php print $_sidebarwidth; ?>" border="0" frameborder="0" id="resizeframeid">
		<frame src="baumFrame.php" name="bframe" scrolling="no" frameborder="0">
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php" name="bm_content_frame">
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</frameset>
<?php
	}
}


/**
 * function startEditInclude()
 * @desc	This function writes the frameset in the resizeframe for an edit-include-window
 */

function startEditIncludeMode(){

	$we_cmds = "we_cmd[0]=edit_document&";

    for($i=1; $i<sizeof($_REQUEST["we_cmd"]); $i++){
    	$we_cmds .= "we_cmd[" . $i . "]=" . $_REQUEST["we_cmd"][$i] . "&";
	}

	if($GLOBALS["BROWSER"]== "NN"){
?>
  <FRAMESET cols="0,*,0" border="0" frameborder="NO">
		<frame src="baumFrame.php" name="bframe" scrolling="no" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php?<?php print $we_cmds ?>SEEM_edit_include=true" name="bm_content_frame" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</FRAMESET>
<?php
	} else {
?>
	<FRAMESET cols="0,*,0" border="1" frameborder="YES">
		<frame src="baumFrame.php" name="bframe" scrolling="no" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php?<?php print $we_cmds ?>SEEM_edit_include=true" name="bm_content_frame" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</FRAMESET>
<?php
	}
}


/**
 * function startSEEMMode()
 * @desc	This function writes the frameset in the resizeframe for the webedition-start
 			in the SEEM-mode.
 */
function startSEEMMode(){
	if($GLOBALS["BROWSER"]== "NN6"){
?>
  <FRAMESET cols="0,*,0" border="1">
		<frame src="<?php print HTML_DIR; ?>white.html" name="bframe" scrolling="no" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php" name="bm_content_frame">
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</FRAMESET>
<?php
	} else {
?>
	<frameset cols="0,*,0" border="0" frameborder="0">
		<frame src="<?php print HTML_DIR; ?>white.html" name="bframe" frameborder="0" scrolling="no" noresize>
		<frame src="<?php print WEBEDITION_DIR; ?>multiContentFrame.php" name="bm_content_frame">
		<frame src="<?php print WEBEDITION_DIR; ?>sideBarFrame.php" name="sidebar">
	</frameset>
<?php
	}
}
?>

<script language="JavaScript" type="text/javascript"><!--
function we_cmd(){
	var args = "";
	for(var i = 0; i < arguments.length; i++){
		args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
	}
	eval('parent.we_cmd('+args+')');
}



//-->
</script>
	</head>
<?php

//	Here begins the controller of the page

//  Edit an included file with SEEM.
if(isset($_REQUEST["SEEM_edit_include"]) && $_REQUEST["SEEM_edit_include"]){
	startEditIncludeMode();

//  We are in SEEM-Mode
} else if($_SESSION["we_mode"] == "seem"){
	startSEEMMode();

//  Open webEdition normally
} else {
	startNormalMode();
}
?>

<noframes>
		<body>
		</body>
	</noframes>
</html>
