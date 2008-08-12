<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_html_tools.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/tools.inc.php');

protect();

htmlTop('webEdition '.$l_tools['tools']);
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
if(isset($_REQUEST['tool']) && !isset($tool)) {
	$tool = $_REQUEST['tool'];
} else {
	$tool = 'navigation';
}
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
