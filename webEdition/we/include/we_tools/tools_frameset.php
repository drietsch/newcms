<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_html_tools.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/tools.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/navigation.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/searchtool.inc.php');

protect();


		
$title = 'webEdition ';
if(isset($_REQUEST['tool'])) {
	$tool = $_REQUEST['tool'];
	if($tool=='weSearch') {
		$title .= $l_tools['tools']. ' - '.$GLOBALS['l_weSearch']['weSearch'];
	}
	elseif($tool=='navigation') {
		$title .= $l_tools['tools']. ' - '.$GLOBALS['l_navigation']['navigation'];
	}
	else {
		// include autoload function
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');
		Zend_Loader::loadClass('we_core_Local');
		$translate = we_core_Local::addTranslation('apps.xml');
		we_core_Local::addTranslation('default.xml', $tool);
		$title .= $translate->_('Applications'). ' - '.$translate->_($tool);
	}
} 

htmlTop($title);

print we_htmlElement::jsElement('

	top.weToolWindow = true;

	function toggleBusy(){
	}
	var makeNewEntry = 0;
	var publishWhenSave = 0;


	function we_cmd() {
		args = "";
		for(var i = 0; i < arguments.length; i++) {
					args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
		}
		eval("top.content.we_cmd("+args+")");
	}


');

if($tool=="weSearch") {
	if(isset($_REQUEST['we_cmd'][1])) {
		$_SESSION["weSearch"]["keyword"] = $_REQUEST['we_cmd'][1];
	}
	//look which search is activ
	if(isset($_REQUEST['we_cmd'][2])) {
		
		if(defined("OBJECT_FILES_TABLE")) {
			$objectFilesTable = OBJECT_FILES_TABLE;
		}
		else {
			$objectFilesTable = "";
		}
		if(defined("OBJECT_TABLE")) {
			$objectTable = OBJECT_TABLE;
		}
		else {
			$objectTable = "";
		}
		
		$table = $_REQUEST['we_cmd'][2];
		switch ($table) {
			
			case FILE_TABLE:
				$tab = 1;
				$_SESSION["weSearch"]["checkWhich"] = 1;
			break;
			case TEMPLATES_TABLE:
				$tab = 2;
				$_SESSION["weSearch"]["checkWhich"] = 2;
			break;
			case $objectFilesTable:
				$tab = 3;
				$_SESSION["weSearch"]["checkWhich"] = 3;
			break;
			case $objectTable:
				$tab = 3;
				$_SESSION["weSearch"]["checkWhich"] = 4;
			break;
		
			default: 
				$tab = $_REQUEST['we_cmd'][2];
		}
	}
	
	if(isset($_REQUEST['we_cmd'][3])) {
		$modelid = $_REQUEST['we_cmd'][3];
	}
}

print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js"));
print we_htmlElement::jsElement("", array("src" => JS_DIR . "libs/yui/yahoo-min.js")) ;
print we_htmlElement::jsElement("", array("src" => JS_DIR . "libs/yui/event-min.js")) ;
print we_htmlElement::jsElement("", array("src" => JS_DIR . "libs/yui/connection-min.js")) ;

?>
</head>
	<frameset rows="26,*" border="0" framespacing="0" frameborder="no">');
		<frame src="/webEdition/we/include/we_tools/tools_header.php?tool=<?php echo $tool; ?>" name="navi" noresize scrolling="no">
		<frame src="/webEdition/we/include/we_tools/tools_content.php?tool=<?php echo $tool; ?><?php echo (isset($modelid)) ?('&modelid=' . $modelid) : ''; ?><?php echo (isset($tab)) ?('&tab=' . $tab) : ''; ?>" name="content" noresize scrolling="no">
	</frameset>
	<body bgcolor="#ffffff"></body>
</html>
